namespace App\Model\Entity;

use Cake\ORM\Entity;

class ArticleLike extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];
}
