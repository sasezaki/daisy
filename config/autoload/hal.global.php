<?php
use Api\ {
    Books\Book, Books\BookCollection
};
use Daisy\Entity\ {
    Post, CommentCollection
};
use Hal\Metadata\ {
    MetadataMap, RouteBasedCollectionMetadata, RouteBasedResourceMetadata
};
use Zend\Hydrator\ObjectProperty as ObjectPropertyHydrator;

return [
    MetadataMap::class => [
        [
            '__class__' => RouteBasedResourceMetadata::class,
            'resource_class' => Book::class,
            'route' => 'book',
            'extractor' => ObjectPropertyHydrator::class,
        ],
        [
            '__class__' => RouteBasedCollectionMetadata::class,
            'collection_class' => BookCollection::class,
            'collection_relation' => 'book',
            'route' => 'books',
        ],
        [
            '__class__' => RouteBasedResourceMetadata::class,
            'resource_class' => Post::class,
            'route' => 'post',
            'extractor' => ObjectPropertyHydrator::class,
        ],
//        [
//            '__class__' => RouteBasedCollectionMetadata::class,
//            'collection_class' => CommentCollection::class,
//            'collection_relation' => 'post',
//            'route' => 'comments',
//        ],
    ],
];