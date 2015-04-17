<?php
/**
 * Created by PhpStorm.
 * User: steven.delgado
 * Date: 25-02-2015
 * Time: 13:41
 */
namespace bbdo\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

/**
 * Entidad de referencia a la base de datos | table the document
 */
class Document
{
    /**
     * @var integer $id_document
     * @ORM\Column(name="id_document",type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     **/
    protected $id_document;
    /**
     * @var string $name_document
     * @ORM\Column(name="name_document",type="string",length="80")
     * */
    protected $name_document;
    /**
     * @var string $shortdescription_document
     * @ORM\Column(name="shortdescription_document",type="string",length="80")
     * */
    protected $shortdescription_document;
    /**
     * @var string $status_document
     * @ORM\Column(name="status_document",type="string",length="80")
     * */
    protected $status_document;
    /**
     * var datetime $created_at
     * @ORM\Column(name="created_at",type="datetime")
     */
    protected $created_at;
    /**
     * @var string $file_document
     * @ORM\Column(name="document_file",type="string",length="255")
     * */
    protected $document_file;
    /**
     * The temporary uploaded file.
     * $this->image stores the filename after the file gets moved to "images/".
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    protected $file;

    /**
     * @return int
     */
    public function getIdDocument()
    {
        return $this->id_document;
    }

    /**
     * @param int $id_document
     */
    public function setIdDocument($id_document)
    {
        $this->id_document = $id_document;
    }

    /**
     * @return string
     */
    public function getNameDocument()
    {
        return $this->name_document;
    }

    /**
     * @param string $name_document
     */
    public function setNameDocument($name_document)
    {
        $this->name_document = $name_document;
    }

    /**
     * @return string
     */
    public function getShortdescriptionDocument()
    {
        return $this->shortdescription_document;
    }

    /**
     * @param string $shortdescription_document
     */
    public function setShortdescriptionDocument($shortdescription_document)
    {
        $this->shortdescription_document = $shortdescription_document;
    }

    /**
     * @return string
     */
    public function getStatusDocument()
    {
        return $this->status_document;
    }

    /**
     * @param string $status_document
     */
    public function setStatusDocument($status_document)
    {
        $this->status_document = $status_document;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param \DateTime|DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;
    }


    public function getDocumentFile()
    {
        if (empty($this->document_file)) {
            $this->document_file = 'placeholder.gif';
        }
        return $this->document_file;
    }

    public function setDocumentFile($document_file)
    {
        $this->document_file = $document_file;
    }

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }
}