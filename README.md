# Doctrine Enum

An anum type for Doctrine MYSQL

## Installation:

```shell
composer require gollumsf/doctrine-enum
```

## Configuration:

```yaml
doctrine:
    dbal:
        types:
            enum_my_enum:  App\Doctrine\MyEnum
```


## Usage:


```php
namespace App\Doctrine;

use GollumSF\Doctrine;
use App\Entity\MyEnum as Enum;

class MyEnum extends EnumType {
	
	public function getEnum(): string {
		return Enum::class;
	}
}

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
	 * @ORM\Column(type="enum_my_enum")
	 * @var int
	 */
	private $enum;
	
	/////////
	// ... //
	/////////
	
}
```
