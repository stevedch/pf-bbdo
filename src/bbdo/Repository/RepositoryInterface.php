<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 07-02-2015
 * Time: 15:15
 */

namespace bbdo\Repository;
//use bbdo\Entity\User;

interface RepositoryInterface
{
    /**
     * retorna el total de entidades que existen en la base de datos.
     *
     * @return int The total number of entities.
     */
    public function getCount();

    /**
     *Devuelve una entidad que coincida con el id.
     *
     * @param integer $id
     *
     * @return object|false An entity object if found, false otherwise.
     * */
    public function find($id);

    /**
     *Elimmina las entidades.
     *
     * @param object $id
     * */
    public function delete($id);

    /**
     * Guarda la entidad en la base de datos.
     * @param object $id
     * @return mixed
     */
    public function save($id);

    /**
     * Retorna una collección de entidades.
     *
     * @param integer $limit
     *   El número de entidades para volver.
     * @param integer $offset
     *   El número de entidades para saltar.
     * @param array $orderBy
     *   Opcionalmente, el orden de información, en la $column => $direction format.
     *
     * @return array A collection of entity objects.
     */
    public function findAll($limit, $offset = 0, $orderBy = array());

}