# Lumen File Manager

[![Code Climate](https://codeclimate.com/github/nordsoftware/lumen-file-manager/badges/gpa.svg)](https://codeclimate.com/github/nordsoftware/lumen-file-manager)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nordsoftware/lumen-file-manager/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nordsoftware/lumen-file-manager/?branch=master)
[![StyleCI](https://styleci.io/repos/38572466/shield?style=flat)](https://styleci.io/repos/38572466)
[![Latest Stable Version](https://poser.pugx.org/nordsoftware/lumen-file-manager/version)](https://packagist.org/packages/nordsoftware/lumen-file-manager)
[![Total Downloads](https://poser.pugx.org/nordsoftware/lumen-file-manager/downloads)](https://packagist.org/packages/nordsoftware/lumen-file-manager)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![Gitter](https://img.shields.io/gitter/room/norsoftware/open-source.svg?maxAge=2592000)](https://gitter.im/nordsoftware/open-source)

File manager module for the [Lumen PHP framework](http://lumen.laravel.com/).

**Please note that this module is still under active development.**

## Requirements

- PHP 5.5.9 or newer
- [Composer](http://getcomposer.org)

## Usage

### Installation

Run the following command to install the package through Composer:

```sh
composer require nordsoftware/lumen-file-manager
```

### Bootstrapping

**Please note that we only support Doctrine for now, but we plan to add Eloquent support soon.**

Add the following lines to ```bootstrap/app.php```:

```php
$app->register('Nord\Lumen\FileManager\Doctrine\ORM\DoctrineServiceProvider');
$app->register('Nord\Lumen\FileManager\FileManagerServiceProvider');
```

Add ```base_path('vendor/nordsoftware/lumen-file-manager/src/Doctrine/ORM/Resources')``` to your Doctrine mapping paths.

Replace ```ORM``` with ```ODM``` if you want to save to MongoDB instead.

You can now use the ```FileManager``` facade or inject the ```Nord\Lumen\FileManager\Contracts\FileManager``` where needed.

### Example

Below is an example of how to use this module to save a file from the request
and return a JSON response with the saved file's ID and URL.

```php
public function uploadFile(Request $request, FileManager $fileManager)
{
    $file = $fileManager->saveFile($request->file('upload'));

    return Response::json([
        'id' => $file->getId(),
        'url' => $fileManager->getFileUrl($file),
    ]);
}
```

## Contributing

Please read the [guidelines](.github/CONTRIBUTING.md).

## License

See [LICENSE](LICENSE).
