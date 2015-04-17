<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 26-02-2015
 * Time: 0:17
 */

namespace bbdo\Repository;

use Doctrine\DBAL\Connection;
use bbdo\Entity\Document;

/**
 *Document Repository
 ***/
class DocumentRepository implements RepositoryInterface
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
     * @param \bbdo\Entity\Document $document
     * @return mixed|void
     */
    public function  save($document)
    {
        $documentData = array(
            'name_document' => $document->getNameDocument(),
            'shortdescription_document' => $document->getShortdescriptionDocument(),
            'status_document' => $document->getStatusDocument(),
        );
        if ($document->getIdDocument()) {
            $newDocument = $this->handleFileupload($document);
            if ($newDocument) {
                $documentData['document_file'] = $document->getDocumentFile();
            }
            $this->db->update('document_ti', $documentData, array('id_document' => $document->getIdDocument()));
        } else {
            $this->db->insert('document_ti', $documentData);
            $id = $this->db->lastInsertId();
            $document->setIdDocument($id);
            $newDocument = $this->handleFileupload($document);
            if ($newDocument) {
                $documentData = array('document_file' => $document->getDocumentFile());
                $this->db->update('document_ti', $documentData, array('id_document' => $document->getIdDocument()));
            }
        }

    }

    /**
     * @param \bbdo\Entity\Document $document
     * @param boolean TRUE if a new document was uploaded, FALSE otherwise.
     */
    protected function handleFileupload($document)
    {
        $file = $document->getFile();
        if ($file) {
            $newDoc = $document->getNameDocument() . '.' . $file->guessExtension();
            $file->move('img' . '/document', $newDoc);
            $document->setFile(null);
            $document->setDocumentFile($newDoc);
            return TRUE;
        }
        return FALSE;
    }


    /**
     * @param integer $id
     * @return int
     */
    public function delete($id)
    {
        return $this->db->delete('document_ti', array('id_document' => $id));
    }

    /**
     * Retorna el total de documentos.
     * @return integer El total de números para las documentos
     */
    public function getCount()
    {
        return $this->db->fetchColumn('SELECT COUNT(id_document) FROM document_ti');
    }

    /**
     *Devuele la entidad del documento que coincida con el id_document.
     * @param integer $id
     * @return \bbdo\Entity\Document|false devuelve un entidad, en caso contrario no devuelve un false
     */
    public function find($id)
    {
        $documentData = $this->db->fetchAssoc('SELECT * FROM document_ti WHERE id_document = ?', array($id));
        return $documentData ? $this->buildDocument($documentData) : FALSE;
    }

    /**
     * Devuelve una colección de document.
     * @param integer $limit
     *   El número de document para volver.
     * @param integer $offset
     *   El número de document para saltar.
     * @param array $orderBy
     *   Opcionalmente, el orden de información, en el $column => $direction format.
     * @return array A collection of users, keyed by user id.
     */
    public function findAll($limit, $offset = 0, $orderBy = array())
    {
        //proporciona un OrderBy por defecto
        if (!$orderBy) {
            $orderBy = array('name_document' => 'ASC');
        }
        $queryBuilder = $this->db->createQueryBuilder();
        $queryBuilder
            ->select('d.*')
            ->from('document_ti', 'd')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('d.' . key($orderBy), current($orderBy));
        $statement = $queryBuilder->execute();
        $documentData = $statement->fetchAll();
        $document = array();
        foreach ($documentData as $doc) {
            $documentId = $doc['id_document'];
            $document[$documentId] = $this->buildDocument($doc);
        }
        return $document;
    }

    /**
     * Crea una instancia de una entidad noticias y establece sus propiedades utilizando datos db.
     *
     * @param array $documentData
     *   el array para la db data.
     *
     * @return \bbdo\Entity\Document $documentData
     */
    protected function buildDocument($documentData)
    {
        //var_dump($documentData) or die();
        $document = new Document();
        $document->setIdDocument($documentData['id_document']);
        $document->setNameDocument($documentData['name_document']);
        $document->setShortdescriptionDocument($documentData['shortdescription_document']);
        $document->setStatusDocument($documentData['status_document']);
       /* $document->setDocumentFile($documentData['document_file']);*/
        $createdAt = new \DateTime($documentData['created_at']);
        $document->setCreatedAt($createdAt);


        return $document;
    }
}