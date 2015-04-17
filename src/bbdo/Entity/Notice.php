<?php
/**
 * Created by PhpStorm.
 * User: steven.delgado
 * Date: 25-02-2015
 * Time: 13:41
 */

namespace bbdo\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Table User the database |  Notices
 */
class Notice
{
    /**
     * @var integer $id_notice
     * @ORM\Column(name="id_notice",type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     **/
    protected $id_notice;
    /**
     * @var string $name_notice
     * @ORM\Column(name="name_notice",type="string",length="80")
     * */
    protected $name_notice;
    /**
     * @var string $shortdescription_notice
     * @ORM\Column(name="shortdescription_notice",type="string",length="125")
     * */
    protected $shortdescription_notice;
    /**
     * @var string $description_notice
     * @ORM\Column(name="description_notice",type="string",length="550")
     * */
    protected $description_notice;
    /**
     * @var string $image_notice
     * @Assert\File(maxSize="5M")
     * @ORM\Column(name="image_notice",type="string",length="255",nullable="true")
     * */
    protected $image_notice;
    /**
     * var date $created_at
     * @ORM\Column(name="created_at",type="datetime")
     */
    protected $created_at;
    /**
     * The temporary uploaded file.
     * $this->image stores the filename after the file gets moved to "images/".
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    protected $file;

    /**
     * @return int
     */
    public function getIdNotice()
    {
        return $this->id_notice;
    }

    /**
     * @param int $id_notice
     */
    public function setIdNotice($id_notice)
    {
        $this->id_notice = $id_notice;
    }

    /**
     * @return string
     */
    public function getNameNotice()
    {
        return $this->name_notice;
    }

    /**
     * @param string $name_notice
     */
    public function setNameNotice($name_notice)
    {
        $this->name_notice = $name_notice;
    }

    /**
     * @return string
     */
    public function getShortdescriptionNotice()
    {
        return $this->shortdescription_notice;
    }

    /**
     * @param string $shortdescription_notice
     */
    public function setShortdescriptionNotice($shortdescription_notice)
    {
        $this->shortdescription_notice = $shortdescription_notice;
    }

    /**
     * @return string
     */
    public function getDescriptionNotice()
    {
        return $this->description_notice;
    }

    /**
     * @param string $description_notice
     */
    public function setDescriptionNotice($description_notice)
    {
        $this->description_notice = $description_notice;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param DateTime|\DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return string
     */
    public function getImageNotice()
    {
        if ($this->image_notice instanceof File) {
            return $this->image_notice;
        }
        return null;
    }

    //codificación de la imagen
    public function getDisplayImgNotice()
    {
        return base64_encode($this->image_notice);
    }

    /**
     * @param file $image_notice
     */
    public function setImageNotice($image_notice)
    {
        $this->image_notice = $image_notice;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }
}