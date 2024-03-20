namespace App\Model\Table;

use Cake\ORM\Table;

class ArticleLikesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->belongsTo('Users');
        $this->belongsTo('Articles');
    }
}
