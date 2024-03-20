<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUserArticleLikes extends AbstractMigration
{
  public function change(): void
  {
    $table = $this->table('user_article_likes');
    $table->addColumn('user_id', 'integer')
      ->addColumn('article_id', 'integer')
      ->addColumn('created_at', 'datetime')
      ->addColumn('updated_at', 'datetime')
      ->addIndex(['user_id', 'article_id'], ['unique' => true])
      ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
      ->addForeignKey('article_id', 'articles', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
      ->create();
  }
}
