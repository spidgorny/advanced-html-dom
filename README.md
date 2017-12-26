# Advanced HTML DOM

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/bavix/advanced-html-dom/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bavix/advanced-html-dom/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/bavix/advanced-html-dom/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/bavix/advanced-html-dom/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/bavix/advanced-html-dom/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bavix/advanced-html-dom/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/bavix/advanced-html-dom/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

[![Latest Stable Version](https://poser.pugx.org/bavix/advanced-html-dom/v/stable)](https://packagist.org/packages/bavix/advanced-html-dom)
[![Latest Unstable Version](https://poser.pugx.org/bavix/advanced-html-dom/v/unstable)](https://packagist.org/packages/bavix/advanced-html-dom)
[![License](https://poser.pugx.org/bavix/advanced-html-dom/license)](https://packagist.org/packages/bavix/advanced-html-dom)
[![composer.lock](https://poser.pugx.org/bavix/advanced-html-dom/composerlock)](https://packagist.org/packages/bavix/advanced-html-dom)

* **Vendor**: bavix
* **Package**: Advanced HTML DOM
* **Version**: [![Latest Stable Version](https://poser.pugx.org/bavix/advanced-html-dom/v/stable)](https://packagist.org/packages/bavix/advanced-html-dom)
* **PHP Version**: 7.1+ 
* **[Composer](https://getcomposer.org/):** `composer require bavix/advanced-html-dom`

The goal of this project is to be a DOM-based drop-in replacement for PHP's simple html dom library.

*How To Use* - The same way as simple. If you use file/str_get_html then you don't need to change anything. If you are instantiating with `new simple_html_dom()` then you will need to change that to `new AdvancedHtmlDom()`

*What's Different* - Mostly just formatting (spaces) in the html. This is added by DOM and there's no way around it. Some non-standard selectors have been dropped but many more standard ones have been added. For example: `img[src!=foo]` was removed because it's not a valid selector. Added are things like `a + b` and `a ~ b` or even `a.foo:not(.bar)`

*What's Better*
- 10x-20x Performance increase
- Reduced memory requirement
- Support for many more css selectors
