# MoReader
[![Build Status](https://api.travis-ci.org/MAXakaWIZARD/MoReader.png?branch=master)](https://travis-ci.org/MAXakaWIZARD/MoReader) 
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/MAXakaWIZARD/MoReader/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/MAXakaWIZARD/MoReader/?branch=master)
[![Code Climate](https://codeclimate.com/github/MAXakaWIZARD/MoReader/badges/gpa.svg)](https://codeclimate.com/github/MAXakaWIZARD/MoReader)
[![Coverage Status](https://coveralls.io/repos/MAXakaWIZARD/MoReader/badge.svg?branch=master)](https://coveralls.io/r/MAXakaWIZARD/MoReader?branch=master)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/0e33f564-fad4-4f89-8078-8c9d0772b0c4.svg)](https://insight.sensiolabs.com/projects/0e33f564-fad4-4f89-8078-8c9d0772b0c4)

[![GitHub tag](https://img.shields.io/github/tag/MAXakaWIZARD/MoReader.svg?label=latest)](https://packagist.org/packages/maxakawizard/mo-reader) 
[![Packagist](https://img.shields.io/packagist/dt/maxakawizard/mo-reader.svg)](https://packagist.org/packages/maxakawizard/mo-reader)
[![Packagist](https://img.shields.io/packagist/dm/maxakawizard/mo-reader.svg)](https://packagist.org/packages/maxakawizard/mo-reader)

[![Minimum PHP Version](http://img.shields.io/badge/php-%3E%3D%205.3-8892BF.svg)](https://php.net/)
[![License](https://img.shields.io/packagist/l/maxakawizard/mo-reader.svg)](https://packagist.org/packages/maxakawizard/mo-reader)

Gettext *.mo files reader for PHP.

This package is compliant with [PSR-4](http://www.php-fig.org/psr/4/), [PSR-1](http://www.php-fig.org/psr/1/), and [PSR-2](http://www.php-fig.org/psr/2/).
If you notice compliance oversights, please send a patch via pull request.

## Usage
```php
$parser = new \MoReader\Reader();
$data = $reader->load('my-file.mo'); //data is an array with entries
```

## License
This library is released under [MIT](http://www.tldrlegal.com/license/mit-license) license.
