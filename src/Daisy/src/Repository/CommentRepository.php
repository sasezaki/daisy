<?php

namespace Daisy\Repository;

use Daisy\ {
    Entity\Comment, Entity\CommentCollection
};

use Zend\Db\ {
    Adapter\AdapterInterface as DbAdapter,
    ResultSet\HydratingResultSet,
    TableGateway\TableGateway
};
use Zend\Hydrator\ObjectProperty;
use Zend\Paginator\Adapter as PaginatorAdapter;


class CommentRepository
{
    /**
     * @var DbAdapter
     */
    private $dbAdapter;

    public function __construct(DbAdapter $dbAdapter)
    {
        $this->dbAdapter = $dbAdapter;
    }

    public function fetchAll() : CommentCollection
    {
        $hydratingResultSet = new HydratingResultSet(new ObjectProperty, new Comment());
        $table = new TableGateway('comment', $this->dbAdapter, null, $hydratingResultSet);


        return new CommentCollection(new PaginatorAdapter\DbTableGateway($table));
    }

//    public function save(Post $post)
//    {
//        $sql = new Sql($this->dbAdapter);
//        $insert = $sql->insert('post');
//        $insert->values([
//           'title' => $post->title,
//           'body'  => $post->body
//        ]);
//        $statement = $sql->prepareStatementForSqlObject($insert);
//        $statement->execute();
//        $driver = $this->dbAdapter->getDriver();
//        return $driver->getConnection()->getLastGeneratedValue();
//    }
}