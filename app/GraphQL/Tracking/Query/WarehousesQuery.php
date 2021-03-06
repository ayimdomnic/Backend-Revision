<?php

namespace App\GraphQL\Tracking\Query;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Query;
use Rebing\GraphQL\Support\Facades\GraphQL;

use App\Repositories\WarehouseRepository;

class WarehousesQuery extends Query
{
    protected $attributes = [
        'name' => 'WarehousesQuery',
        'description' => 'A query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('warehouse'));
    }

    public function args()
    {
        return [

        ];
    }

    public function resolve($root, $args, SelectFields $fields, ResolveInfo $info)
    {
        /** @var WarehouseRepository $warehousesRepository */
        $warehousesRepository = app(WarehouseRepository::class);

        $select = $fields->getSelect();
        $with = $fields->getRelations();

        return $warehousesRepository->filter($args)->with($with)->select($select)->get();
    }
}