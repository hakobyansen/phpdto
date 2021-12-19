[![Latest Stable Version](https://poser.pugx.org/codebot/phpdto/v/stable)](https://packagist.org/packages/codebot/phpdto)
[![Build Status](https://travis-ci.com/c0d3b0t/phpdto.svg?branch=master)](https://travis-ci.com/c0d3b0t/phpdto)
[![Total Downloads](https://poser.pugx.org/codebot/phpdto/downloads)](https://packagist.org/packages/codebot/phpdto)
[![License](https://poser.pugx.org/codebot/phpdto/license)](https://packagist.org/packages/codebot/phpdto)

## About

> A CLI tool for PHP Data Transfer Objects generation.

This utility gives an ability to generate PHP 8 DTO classes based on json pattern.

## Installation

Install the package via composer:

`composer require --dev codebot/phpdto 0.3.*`

**Please consider that the minimum PHP version required by this package is 8.0.**

## Initialization

`vendor/bin/phpdto init`

The current working directory is the directory from where you are invoking `phpdto` command.

This command will initialize the phpdto and create **phpdto.json** configuration file and **phpdto_patterns** directory
in your current working directory.

## Configuration

**phpdto.json** configuration file contains following variables:

*PHP_DTO_PATTERNS_DIR* - the directory, where you must store json patterns for DTOs.

*PHP_DTO_NAMESPACE* - the namespace of generated DTO classes.

*PHP_DTO_CLASS_POSTFIX* - postfix of DTO classes, e.g. Item (no postfix), ItemDto (the postfix is "Dto").

***These variables are stored as environment variables.***

## Usage

To generate DTO class you must create a pattern, which is a json file that contains information about the generated class.

##### DTO JSON Pattern

An example of DTO pattern:

```json
{
  "class": "item",
  "namespace_postfix": "",
  "props": {
    "id": "int",
    "count": "?int",
    "name": "string",
    "description": "?string",
    "is_active": "bool"
  }
}
```

**class**

A class name that will be combined with *PHP_DTO_CLASS_POSTFIX* specified in `phpdto.json` config file.

So, if the class name is `item`, and the class postfix config value is `Dto`, then the generated class name will be `
ItemDto`.

**namespace_postfix**

A postfix of the generated DTO class namespace that will be combined with *PHP_DTO_NAMESPACE* specified in `phpdto.json`
config file.

So, if the namespace postfix is `\User`, and the default DTO namespace is `App\Dto`, then the namespace of the generated 
class will be `App\Dto\User`.

You can leave namespace postfix empty.

**props**

This object contains information about DTO class properties and methods. Keys will be cast to class properties. Values
contain information about getters return types.

`"description" : "?string"` - due to this pair `$_description` property will be added to DTO class with 
`private ?string $_description` property and `getDescription(): ?string` method, that expects return type 
"string" and allows null.

##### Generating DTO

Given you have already created pattern as json file named `item.json` in the `phpdto_patterns` folder.

Run `vendor/bin/phpdto -f=item` to have your DTO class generated. It will be stored under namespace specified in
the `phpdto.json` config file combined with namespace postfix specified in your pattern.

Given you are generating DTO class from the pattern shown in "DTO JSON Pattern" section, then you will have following class
generated.

```php
<?php

namespace App\Dto;

use PhpDto\Dto;
use PhpDto\DtoSerialize;
use PhpDto\ToArray;

class ItemDto extends Dto
{
	use DtoSerialize, ToArray;

	private int $_id;
	private ?int $_count;
	private string $_name;
	private ?string $_description;
	private bool $_isActive;

	public function __construct( array $item )
	{
	    $this->_id = $item['id'];
	    $this->_count = $item['count'];
	    $this->_name = $item['name'];
	    $this->_description = $item['description'];
	    $this->_isActive = $item['is_active'];
	}

	public function getId(): int
	{
	    return $this->_id;
	}

	public function getCount(): ?int
	{
	    return $this->_count;
	}

	public function getName(): string
	{
	    return $this->_name;
	}

	public function getDescription(): ?string
	{
	    return $this->_description;
	}

	public function getIsActive(): bool
	{
	    return $this->_isActive;
	}
}
```

##### How to use

There are 2 mapper methods:

`static function mapArray(array $items, bool $shouldSerialize = false): array`

`static function mapSingle(array $item, bool $shouldSerialize = false): Dto|stdClass`

Use `mapArray` when you need to map multidimensional array, otherwise use `mapSingle`.

Mapping example:

###### Single

```php
$itemData = [
    'id' => 1,
    'name' => 'Dummy Item',
    'description' => 'Some dummy description.',
    'count' => 10,
    'is_active' => true,
    'meta' => [
        'meta_title' => 'Dummy meta title',
        'meta_description' => 'Dummy meta description',
    ],
    'tags' => 'TagOne, TagTwo, TagThree'
];

$item = ItemDto::mapSingle( $itemData );

// Now you are able to access DTO properties via getters

$item->getId();
$item->Name();
$item->getDescription();
$item->getCount();
$item->getIsActive();
```

###### Multidimensional

```php
$itemData = [
    [
        'id' => 1,
            'name' => 'Dummy Item',
            'description' => 'Some dummy description.',
            'count' => 10,
            'is_available' => true, 
            'meta' => [
                'meta_title' => 'Dummy meta title',
                'meta_description' => 'Dummy meta description',
            ],
            'tags' => 'TagOne, TagTwo, TagThree'
    ],
    // more items
];

$items = ItemDto::mapArray( $itemData ); // array of instance of ItemDto class

foreach( $items as $item )
{
    $item->getId();
    // ... 
}
```

***CONSIDER REFACTORING THE CONSTRUCTOR OF GENERATED DTO CLASS DEPENDING ON THE DATA STRUCTURE OF THE ARRAY YOU
WANT TO MAP.***

Sometimes you may want to have DTOs as objects that you could pass in AJAX response or whatever you need for.

The second parameter of the mapper methods is a flag that decides if the data should be serialized.

`ItemDto::mapSingle( $itemData, true )` - this will return you the DTO as a serialized object:

```
{
  "id": 1
  "name": "Dummy Item"
  "description": "Some dummy description."
  "count": 10
  "isActive": true
}
```

Same is true for `mapArray` method.

##### DTO Faker

You can generate fake data for your DTOs easily using `PhpDto\Services\DtoFaker` class.

```php
$fakeData = DtoFaker::fakeSingle( ItemDto::class ); // array that contains fake data for ItemDto
$item = ItemDto::mapSingle( $fakeData );
```

Now your item looks like this:

```
{
    "id": 993
    "count": 340
    "name": "2R9ifLLxfG965wikJWrr"
    "description": "MluADBj2rwmAjBC6ZyH4"
    "isActive": false
}
```   

All the values are randomly generated, even the boolean value for isActive field.

You can fake multidimensional array via `DtoFaker::fakeArray` method.

In the example below we want to fake data for 10 items.

```php
$fakeData = DtoFaker::fakeArray( ItemDto::class, 10 );
$items = ItemDto::mapArray( $fakeData );
```

Second parameter of the `Dto::fakeArray` method is the count of generated items.

`Dto::fakeSingle` and `Dto::fakeArray` methods are using PHP Reflection API to get information about properties and
getters.

Alternatively you can use `Dto::fakeSingeFromPattern` and `Dto::fakeArrayFromPattern` methods. You must pass them full
path to your json pattern:  
`Dto::fakeArrayFromPattern('/full/path/to/pattern.json')`.

###### `ToArray` trait and `toArray(): array` method.

When you need to cast your DTO object to array, you can use the `toArray` method.

```php
<?php

namespace App\Dto;

use PhpDto\Dto;
use PhpDto\ToArray;

class MockDto extends Dto
{
    use ToArray;
    
    private ?string $_name;
    private int $_count;
    private bool $_isTrue;
    
    public function __construct( array $data )
    {
        $this->_name   = $data['name'];
        $this->_count  = $data['count'];
        $this->_isTrue = $data['is_true'];
    }
    
    public function getName(): ?string
    {
        return $this->_name;
    }
    
    public function getCount(): int
    {
        return $this->_count;
    }

    public function getIsTrue(): bool
    {
        return $this->_isTrue;
    }
}

$mockData = [
    'name' => 'Mock name',
	'count'   => 4,
	'is_true' => true
];

$dto = new MockDto($mockData);

$arr = $dto->toArray();

var_dump($arr);
```

The output will be:
```
array(3) {
  'name' =>
  string(9) "Mock name"
  'count' =>
  int(4)
  'is_true' =>
  bool(true)
}
```

Though, if you want to keep array keys format to be same as class fields, you can pass false to `toArray` method:
`$arr = $dto->toArray(false);` or `$arr = $dto->toArray(toSnakeCase: false);`

The output then will be:
```
array(3) {
  'name' =>
  string(9) "Mock name"
  'count' =>
  int(4)
  'isTrue' =>
  bool(true)
}
```
So, now the `isTrue` key is camelCase. 
