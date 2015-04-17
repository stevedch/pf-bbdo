<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 26-02-2015
 * Time: 0:17
 */

namespace bbdo\Repository;

use Doctrine\DBAL\Connection;
use bbdo\Entity\Notice;

/**
 *Notices Repository
 ***/
class NoticeRepository implements RepositoryInterface
{
    /**
     * @var \Doctrine\DBAL\Connection
     */

    protected $db;

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }

    /**
     *Guarda los avisos en la base de datos
     *
     * @param \bbdo\Entity\Notice $notice
     *
     * @return mixed|void
     */
    public function  save($notice)
    {
        $stream = null;
        if ($image = $notice->getImageNotice()) {
            $strm = fopen($image->getRealPath(), 'rb');
            $stream = stream_get_contents($strm);
            $notice->setImageNotice($stream);
        }
        $noticeData = array(
            'name_notice' => $notice->getNameNotice(),
            'shortdescription_notice' => $notice->getShortdescriptionNotice(),
            'description_notice' => $notice->getDescriptionNotice(),
        );
        if ($stream) $noticeData['image_notice'] = $stream;
        if ($notice->getIdNotice()) {
            $this->db->update('notice', $noticeData, array('id_notice' => $notice->getIdNotice()));
        } else {
            $this->db->insert('notice', $noticeData);
            $id = $this->db->lastInsertId();
            $notice->setIdNotice($id);
        }
        return $notice;
    }

    /**
     *Elimina los avisos en la base de datos.*
     * @param \bbdo\Entity\Notice $notice *
     * @return int
     */
    public function delete($notice)
    {
        return $this->db->delete('notice', array('id_notice', $notice->getIdNotice()));
    }

    /**
     * Retorna el total de notices.*
     * @return integer El total de números para las noticias
     */
    public function getCount()
    {
        return $this->db->fetchColumn('SELECT COUNT(id_notice) FROM notice');
    }

    /**
     *Devuele una noticia que coincida con el id_notice.*
     * @param integer $id *
     * @return \bbdo\Entity\Notice|false devuelve un entidad, en caso contrario no devuelve un false
     */
    public function find($id)
    {
        $noticeData = $this->db->fetchAssoc('SELECT * FROM notice WHERE id_notice = ?', array($id));
        return $noticeData ? $this->buildNotice($noticeData) : FALSE;
    }

    /**
     * Devuelve una colección de noticias.
     * @param integer $limit
     * El número de noticias para volver.
     * @param integer $offset
     * El número de noticias para saltar.
     * @param array $orderBy
     * Opcionalmente, el orden de información, en el $column => $direction format.
     * @return array A collection of users, keyed by user id.
     */
    public function findAll($limit, $offset = 0, $orderBy = array())
    {
        //proporciona un OrderBy por defecto
        if (!$orderBy) {
            $orderBy = array('name_notice' => 'ASC');
        }
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('n.*')
            ->from('notice', 'n')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('n.' . key($orderBy), current($orderBy));
        $statement = $queryBuilder->execute();
        $noticesData = $statement->fetchAll();
        $notice = array();
        foreach ($noticesData as $noticeData) {
            $noticeId = $noticeData['id_notice'];
            $notice[$noticeId] = $this->buildNotice($noticeData);
        }
        return $notice;
    }

    public function viewAction()
    {
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('n.*')
            ->from('notice', 'n');
        $statement = $queryBuilder->execute();
        $noticesData = $statement->fetchAll();
        $notice = array();
        foreach ($noticesData as $noticeData) {
            $noticeId = $noticeData['id_notice'];
            $notice[$noticeId] = $this->buildNotice($noticeData);
        }
        return $notice;
    }

    /**
     * Crea una instancia de una entidad noticias y establece sus propiedades utilizando datos db.*
     * @param array $noticeData el array para la db data.*
     * @return \bbdo\Entity\Notice $noticeData
     */
    protected function buildNotice($noticeData)
    {
        $notice = new Notice();
        $notice->setIdNotice($noticeData['id_notice']);
        $notice->setNameNotice($noticeData['name_notice']);
        $notice->setShortdescriptionNotice($noticeData['shortdescription_notice']);
        $notice->setDescriptionNotice($noticeData['description_notice']);
        $notice->setImageNotice($noticeData['image_notice']);
        $createdAt = new \DateTime($noticeData['created_at']);
        $notice->setCreatedAt($createdAt);
        return $notice;
    }
}