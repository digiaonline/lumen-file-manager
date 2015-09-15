# lumen-file-manager

[![Latest Stable Version](https://poser.pugx.org/nordsoftware/lumen-file-manager/version)](https://packagist.org/packages/nordsoftware/lumen-file-manager)
[![Total Downloads](https://poser.pugx.org/nordsoftware/lumen-file-manager/downloads)](https://packagist.org/packages/nordsoftware/lumen-file-manager)
[![License](https://poser.pugx.org/nordsoftware/lumen-file-manager/license)](https://packagist.org/packages/nordsoftware/lumen-file-manager)

File manager module for the Lumen PHP framework.

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

Replace \Doctrine\ORM in first line with \Doctrine\ODM if you want to save to MongoDB instead.
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

Please note the following guidelines before submitting pull requests:

- Use the [PSR-2 coding style](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
- Create pull requests for the *develop* branch

## License

See [LICENSE](LICENSE).
