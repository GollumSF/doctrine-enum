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
            enum_my_type:  App\Doctrine\MyTypeEnum
```


## Usage:


```php
namespace App\Doctrine;

use GollumSF\Doctrine\EnumType;
use App\Entity\MyType;

class MyTypeEnum extends EnumType {
	
	public function getEnum(): string {
		return MyType::class;
	}
}

namespace App\Entity;

use GollumSF\Enum\Enum;
use Doctrine\ORM\Mapping as ORM;

class MyType extends Enum {
	const VALUE1 = 'VALUE1';
	const VALUE2 = 'VALUE2';
	const VALUE3 = 'VALUE3';
}

/**
 * @ORM\Entity()
 */
class Entity {
	
	/**
	 * @ORM\Column(type="enum_my_type")
	 * @var int
	 */
	private $enum;
	
	/////////
	// ... //
	/////////
	
}
```
