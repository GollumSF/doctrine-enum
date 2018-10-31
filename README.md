# Doctrine Enum

An tinyint type for Doctrine MYSQL

## Installation:

```shell
composer require gollumsf/doctrine-enum
```

## Configuration:

```yaml
doctrine:
    dbal:
        types:
            tinyint:  GollumSF\Doctrine\Enum
```


## Usage:


```php
namespace App\Entity;

use GollumSF\Enum\Enum;
use Doctrine\ORM\Mapping as ORM;

class MyEnum extends Enum {
	const VALUE1 = 'VALUE1';
	const VALUE2 = 'VALUE2';
	const VALUE3 = 'VALUE3';
}

/**
 * @ORM\Table()
 */
class Entity {
	
	/**
	 * @ORM\Column(type="enum", options={"enum"=MyEnum::class})
	 * @var int
	 */
	private $enum;
	
	/////////
	// ... //
	/////////
	
}
```
