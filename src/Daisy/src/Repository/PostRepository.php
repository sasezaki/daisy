<?php

namespace Daisy\Repository;

use Zend\Db\ {
    Adapter\AdapterInterface as DbAdapter,
    ResultSet\HydratingResultSet,
    Sql\Sql,
    TableGateway\TableGateway
};
use Zend\Hydrator\ObjectProperty;

use Daisy\Entity\Post;

class PostRepository
{
    /**
     * @var DbAdapter
     */
    private $dbAdapter;

    public function __construct(DbAdapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function get(int $id) : Post
    {
        $hydratingResultSet = new HydratingResultSet(new ObjectProperty, new Post);
        $table = new TableGateway('post', $this->dbAdapter, null, $hydratingResultSet);
        $resultSet = $table->select(['id' => $id]);
        return $resultSet->current();
    }

    public function save(Post $post)
    {
        $sql = new Sql($this->dbAdapter);
        $insert = $sql->insert('post');
        $insert->values([
           'title' => $post->title,
           'body'  => $post->body
        ]);
        $statement = $sql->prepareStatementForSqlObject($insert);
        $statement->execute();
        $driver = $this->dbAdapter->getDriver();
        return $driver->getConnection()->getLastGeneratedValue();
    }
}