/**
 * Project: EU Cookie Law Add-On
 *
 * @copyright 2017 Fabian Bitter
 * @author Fabian Bitter (f.bitter@bitter-webentwicklung.de)
 * @version 1.0
 */

var CookieDisclosure = {
    settings: [],
    popup: null,
    originalTop: null,
    
    buildUrl: function (methodName) {
        return this.settings.serviceUrl + "/" + methodName;
    },

    callMethod: function (methodName, clb) {
        $.ajax({
            dataType: "json",
            url: this.buildUrl(methodName),
            success: function () {
                clb();
            }
        });
    },

    optIn: function () {
        // remove popup
        this.removePopup();
        
        this.setStatus(true);
        
        // Remove Cookies server side
        this.callMethod("optIn", function () {
            location.reload();
        });
    },
  
    optOutAndRemove: function() {
        // remove popup
        this.removePopup();
        
        this.clearAll();
      
        Cookies.remove('cookie-disclosure');
        
        // Remove Cookies server side
        this.callMethod("optOut", function () {
            location.reload();
        });
    },

    optOut: function () {
        // remove popup
        this.removePopup();
        
        this.clearAll();
      
        this.setStatus(false);
        
        // Remove Cookies server side
        this.callMethod("optOut", function () {
            location.reload();
        });
    },
    
    setStatus: function(status) {
        Cookies.set('cookie-disclosure', status,  { expires: 365 });
    },

    getStatus: function() {
        return Cookies.get('cookie-disclosure');
    },

    clearAll: function() {
        return this.clearLocalStorage() && this.clearSessionStorage() && this.clearCookies();
    },
    
    clearLocalStorage: function() {
        // clear local storage if available
        if (typeof localStorage !== "undefined") {
            localStorage.clear();
        }
        
        return true;
    },

    clearSessionStorage: function() {
        // clear session storage if available
        if (typeof sessionStorage !== "undefined") {
            sessionStorage.clear();
        }
        
        return true;
    },

    clearCookies: function() {
        // Remove cookies client side
        Object.keys(Cookies.get()).forEach(function (cookie) {
            Cookies.remove(cookie);
        });
        
        return true;
    },
    
    init: function (settings) {
        this.settings = settings;

        if (typeof this.getStatus() === "undefined") {
            this.createPopup();
        
            this.bindEventHandlers();
        }
    },
    
    bindEventHandlers: function() {
        var self = this;
        
        $(window).bind("scroll resize", function() {
            self.refresh();
        });
        
        self.refresh();
    },

    createPopup: function () {
        var self = this;
        
        var infoText = $('<p/>', {
            class: 'message',
            text: this.settings.content.message,
            style: "color: " + this.settings.colors.popup.text + "; "
        });
        
        infoText.append(
            $('<a/>', {
                class: 'privacy-link',
                href: this.settings.content.href,
                text: this.settings.content.link,
                style: "color: " + this.settings.colors.popup.text + "; "
            })
        );
        
        var infoContainer = $('<div/>', {
            class: 'info-container'
        });

        infoContainer.append(
            infoText
        );

        var buttonsContainer = $('<div/>', {
            class: 'buttons-container'
        });

        switch (this.settings.type) {
            case "opt-out":
                buttonsContainer.append(
                    $('<a/>', {
                        class: 'btn btn-default',
                        text: this.settings.content.decline,
                        click: function() {
                            self.optOut();
                        },
                        style: "background-color: " + this.settings.colors.button.secondary.background + "; " +
                               "border-color: " + this.settings.colors.button.secondary.background + "; " +
                               "color: " + this.settings.colors.button.secondary.text + "; "
                    })
                );
                
                buttonsContainer.append(
                    $('<a/>', {
                        class: 'btn btn-primary',
                        text: this.settings.content.dismiss,
                        click: function() {
                            self.optIn();
                        },
                        style: "background-color: " + this.settings.colors.button.primary.background + "; " +
                               "border-color: " + this.settings.colors.button.primary.border + "; " +
                               "color: " + this.settings.colors.button.primary.text + "; "
                    })      
                );
        
                break;

            case "opt-in":
                buttonsContainer.append(
                    $('<a/>', {
                        class: 'btn btn-default',
                        text: this.settings.content.deny,
                        click: function() {
                            self.optOut();
                        },
                        style: "background-color: " + this.settings.colors.button.secondary.background + "; " +
                               "border-color: " + this.settings.colors.button.secondary.background + "; " +
                               "color: " + this.settings.colors.button.secondary.text + "; "
                    })
                );
                
                buttonsContainer.append(
                    $('<a/>', {
                        class: 'btn btn-primary',
                        text: this.settings.content.allow,
                        click: function() {
                            self.optIn();
                        },
                        style: "background-color: " + this.settings.colors.button.primary.background + "; " +
                               "border-color: " + this.settings.colors.button.primary.border + "; " +
                               "color: " + this.settings.colors.button.primary.text + "; "
                    })      
                );
        
                break;

            default:
                buttonsContainer.addClass("single-button");
                
                buttonsContainer.append(
                    $('<a/>', {
                        class: 'btn btn-primary',
                        text: this.settings.content.dismiss,
                        click: function() {
                            self.optIn();
                        },
                        style: "background-color: " + this.settings.colors.button.primary.background + "; " +
                               "border-color: " + this.settings.colors.button.primary.border + "; " +
                               "color: " + this.settings.colors.button.primary.text + "; "
                    })
                );
                
                break;
        }
        
        this.popup = $('<div/>', {
            class: 'cookie-disclosure ' + (this.settings.isRTL ? "rtl" : "") + ' ' + this.settings.position,
            style: "background-color: " + this.settings.colors.popup.background + "; " +
                   ($("#ccm-toolbar").length ? "margin-top: " + $("#ccm-toolbar").height() + "px" : "")
        }).prependTo('body');

        this.popup.append(infoContainer);
        this.popup.append(buttonsContainer);

    },
    
    refresh: function() {
        if (this.settings.position === "top") {
            if (this.popup === null) {
                $("body").css("paddingTop", this.originalTop);
                
            } else {
                if (this.originalTop === null) {
                    this.originalTop = parseInt($("body").css("paddingTop"));
                }

                var newTop = 
                        this.originalTop +
                        this.popup.height() +
                        parseInt(this.popup.css("paddingTop")) +
                        parseInt(this.popup.css("paddingBottom"));
                $("body").css("paddingTop", newTop);
                
            } 
            
        }
    },
    
    removePopup: function() {
        if (typeof this.popup !== "undefined" && this.popup !== null) {
            this.popup.remove();
        
            this.popup = null;
      
            this.refresh();
        }
    }
};