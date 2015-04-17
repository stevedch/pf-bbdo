<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 01-03-2015
 * Time: 16:11
 */
namespace bbdo\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;

/**
 * Entidad de referencia a la base de datos  Users
 * */
class User implements UserInterface
{
    /**
     * @var integer $id_user
     * @ORM\Column(name="id_user",type="integer",nullable="false")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     **/
    protected $id_user;
    /**
     * @var string $run_user
     * @ORM\Column(name="run_user",type="string",length="13",nullable="false")
     * */
    protected $run_user;
    /**
     * @var string $name_user
     * @ORM\Column(name="name_user",type="string",length="80",nullable="false")
     * */
    protected $name_user;
    /**
     * @var string $lastname_user
     * @ORM\Column(name="lastname_user",type="string",length="80",nullable="false")
     * */
    protected $lastname_user;
    /**
     * @var string $second_surname
     * @ORM\Column(name="second_surname",type="string",length="80",nullable="true")
     * */
    protected $second_surname;
    /**
     * var date $birth_date
     * @ORM\Column(name="birth_date",type="date",nullable="true")
     */
    protected $birth_date;
    /**
     * var date $start_date
     * @ORM\Column(name="start_date",type="date",nullable="false")
     */
    protected $start_date;
    /**
     * var date $end_date
     * @ORM/Column(name="end_date",type"date",nullable="true")
     * */
    protected $end_date;
    /**
     * var date $created_at
     * @ORM\Column(name="created_at",type="datetime",nullable="false")
     */
    protected $created_at;
    /**
     * @var string $post_user
     * @ORM\Column(name="post_user",type="string",length="80",nullable="false")
     * */
    protected $post_user;
    /**
     * @var string $area_user
     * @ORM\Column(name="area_user",type="string",length="80",nullable="false")
     * */
    protected $area_user;
    /**
     * @var string $mail
     * @ORM\Column(name="mail",type="string",length="255",nullable="false")
     * */
    protected $mail;
    /**
     * @var string $annex_telephone
     * @ORM\Column(name="annex_telephone",type="string",length="80",nullable="true")
     * */
    protected $annex_telephone;
    /**
     * @var string $photo_user
     * @Assert\File(maxSize="6000000")
     * @ORM\Column(name="photo_user",type="string",length="255",nullable="true")
     * */
    protected $photo_user;
    /**
     * @var string $status_user
     * @ORM\Column(name="status_user",type="string",length="80",nullable="false")
     * */
    protected $status_user;
    /**
     * @var string $username
     * @ORM\Column(name="username",type="string",length="80",nullable="true")
     * */
    protected $username;
    /**
     * @var string $password
     * @ORM\Column(name="password",type="string",length="255",nullable="true")
     * */
    protected $password;
    /**
     * @var string $salt
     * @ORM\Column(name="salt",type="string",length="255",nullable="true")
     * */
    protected $salt;
    /**
     * ROLE_USER or ROLE_ADMIN.
     * @var string $role
     * @ORM\Column(name="role",type="string",length="80",nullable="true")
     * */
    protected $role;
    /**
     * The temporary uploaded file.
     * $this->image stores the filename after the file gets moved to "images/".
     * @var \Symfony\Component\HttpFoundation\File\UploadedFile
     */
    protected $file;
    /**
     * ROLE_PUBLIC
     * @var string $role_public
     * @ORM\Column(name="role_public",type="string",length="80",nullable="true")
     * */
    protected $role_public;

    /**
     * @return int
     */
    public function getIdUser()
    {
        return $this->id_user;
    }

    /**
     * @param int $id_user
     */
    public function setIdUser($id_user)
    {
        $this->id_user = $id_user;
    }


    /**
     * @return int
     */
    public function getRunUser()
    {
        return $this->run_user;
    }

    /**
     * @param int $run_user
     */
    public function setRunUser($run_user)
    {
        $this->run_user = $run_user;
    }


    /**
     * @return string
     */
    public function getNameUser()
    {
        return $this->name_user;
    }

    /**
     * @param string $name_user
     */
    public function setNameUser($name_user)
    {
        $this->name_user = $name_user;
    }

    /**
     * @return string
     */
    public function getLastnameUser()
    {
        return $this->lastname_user;
    }

    /**
     * @param string $lastname_user
     */
    public function setLastnameUser($lastname_user)
    {
        $this->lastname_user = $lastname_user;
    }

    /**
     * @return string
     */
    public function getSecondSurname()
    {
        return $this->second_surname;
    }

    /**
     * @param string $second_surname
     */
    public function setSecondSurname($second_surname)
    {
        $this->second_surname = $second_surname;
    }


    /**
     * @return mixed
     */
    public function getBirthDate()
    {
        return $this->birth_date;
    }

    /**
     * @param mixed $birth_date
     */
    public function setBirthDate(\DateTime $birth_date)
    {
        $this->birth_date = $birth_date;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @param mixed $start_date
     */
    public function setStartDate(\DateTime $start_date)
    {
        $this->start_date = $start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @param mixed $end_date
     */
    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
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

    /**
     * @return string
     */
    public function getPostUser()
    {
        return $this->post_user;
    }

    /**
     * @param string $post_user
     */
    public function setPostUser($post_user)
    {
        $this->post_user = $post_user;
    }

    /**
     * @return string
     */
    public function getAreaUser()
    {
        return $this->area_user;
    }

    /**
     * @param string $area_user
     */
    public function setAreaUser($area_user)
    {
        $this->area_user = $area_user;
    }

    /**
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return string
     */
    public function getAnnexTelephone()
    {
        return $this->annex_telephone;
    }

    /**
     * @param string $annex_telephone
     */
    public function setAnnexTelephone($annex_telephone)
    {
        $this->annex_telephone = $annex_telephone;
    }

    /**
     * @return string
     */
    public function getPhotoUser()
    {
        if ($this->photo_user instanceof File) {
            return $this->photo_user;
        }
        return null;
    }

    //codificación de la imagen
    public function getdisplayPhoto()
    {
        return base64_encode($this->photo_user);
    }

    /**
     * @param mixed $photo_user
     * @return file $photo_user
     */
    public function setPhotoUser($photo_user)
    {
        $this->photo_user = $photo_user;
    }

    /**
     * @return string
     */
    public function getStatusUser()
    {
        return $this->status_user;
    }

    /**
     * @param string $status_user
     */
    public function setStatusUser($status_user)
    {
        $this->status_user = $status_user;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getRolePublic()
    {
        return $this->role_public;
    }

    /**
     * @param string $role_public
     */
    public function setRolePublic($role_public)
    {
        $this->role_public = $role_public;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array(
            $this->getRole(),
        );
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
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