<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 07-02-2015
 * Time: 12:56
 */

namespace bbdo\Repository;

use Doctrine\DBAL\Connection;
use bbdo\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * User repository
 */
class UserRepository implements RepositoryInterface, UserProviderInterface
{
    /**
     * @var \Doctrine\DBAL\Connection
     *
     **/
    protected $database;

    /**
     * @var \Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder
     */
    protected $encoder;

    public function __construct(Connection $db, $encoder)
    {
        $this->database = $db;
        $this->encoder = $encoder;
    }

    public function save($user)
    {
        /**
         * @var \bbdo\Entity\User $user
         * */
        $stream = null;
        if ($foto = $user->getPhotoUser()) {
            $strm = fopen($foto->getRealPath(), 'rb');
            $stream = stream_get_contents($strm);
            $user->setPhotoUser($stream);
        }
        $userData = array(
            'run_user' => $user->getRunuser(),
            'name_user' => $user->getNameUser(),
            'lastname_user' => $user->getLastnameUser(),
            'second_surname' => $user->getSecondSurname(),
            'birth_date' => date_format($user->getBirthDate(), 'Y-m-d'),
            'start_date' => date_format($user->getStartDate(), 'Y-m-d'),
            'post_user' => $user->getPostUser(),
            'area_user' => $user->getAreaUser(),
            'annex_telephone' => $user->getAnnexTelephone(),
            'username' => $user->getUsername(),
            'mail' => $user->getMail(),
            'status_user' => $user->getStatusUser(),
            'role' => $user->getRole(),
            'role_public' => $user->getRolePublic()
        );
        if ($stream) $userData['photo_user'] = $stream;
        //Si se cambió la contraseña, vuelva a cifrarlo.
        if (strlen($user->getPassword()) != 88) {
            $userData['salt'] = uniqid(mt_rand());
            $userData['password'] = $this->encoder->encodePassword($user->getPassword(), $userData['salt']);
        }
        if ($user->getIdUser()) {
            //Si se ha subido una imagen nueva, asegúrese de que el nombre del archivo se establece.
            $newFile = $this->handleFileupload($user);
            if ($newFile) {
                $userData['photo_user'] = $user->getPhotoUser();
            }
            $this->database->update('users', $userData, array('id_user' => $user->getIdUser()));
        } else {
            //El usuario es nuevo, tenga en cuenta la fecha y hora de creación.
            $this->database->insert('users', $userData);
            // Obtener el ID del usuario recién creado y lo asigna sobre la entidad.
            $id = $this->database->lastInsertId();
            $user->setIdUser($id);
            // Si se ha subido una imagen nueva, actualice el usuario con el nuevo
            // Nombre del archivo.
            $newFile = $this->handleFileupload($user);
            if ($newFile) {
                $newData = array('photo_user' => $user->getPhotoUser());
                $this->database->update('users', $newData, array('id_user' => $id));
            }
        }
        return $user;
    }

    /**
     * @param \bbdo\Entity\User $user
     * @param boolean TRUE si una nueva imagen de usuario se ha subido, FALSE de lo contrario.*
     * @return bool
     */
    protected function handleFileupload($user)
    {
        $file = $user->getFile();
        if ($file) {
            $newFilename = $file->guessExtension();
            $user->setPhotoUser($newFilename);
            $file->move($newFilename);
            $user->setFile(null);
            return TRUE;
        }
        return FALSE;
    }

    /**
     * Retorna el total de usuarios existentes en la base de datos.
     * @return integer The total number of users.
     */
    public function getCount()
    {
        return $this->database->fetchColumn('SELECT COUNT(id_user) FROM users');
    }

    /**
     * Retorna un id de usuario, que coincida con el id suministrado.
     * @param integer $id
     * @return \bbdo\Entity\User|false Un objeto de entidad si se encuentra, false en caso contrario.
     */
    public function find($id)
    {
        $userData = $this->database->fetchAssoc('SELECT * FROM users WHERE id_user = ?', array($id));
        return $userData ? $this->buildUser($userData) : FALSE;
    }

    /**
     * Devuelve una colección de usuarios.
     * @param integer $limit
     *   El número de usuarios para volver.
     * @param integer $offset
     *   El número de usuarios para saltar.
     * @param array $orderBy
     *   Opcionalmente, el orden de información, en el $column => $direction format.
     * @return array A collection of users, keyed by user id.
     */
    public function findAll($limit, $offset = 1, $orderBy = array())
    {
        if (!$orderBy) {
            $orderBy = array('id_user' => 'ASC');
        }
        $queryBuilder = $this->database->createQueryBuilder();
        $queryBuilder
            ->select('u.*')
            ->from('users', 'u')
            ->setMaxResults($limit)
            ->setFirstResult($offset)
            ->orderBy('u.' . key($orderBy), current($orderBy));
        $statement = $queryBuilder->execute();
        $usersData = $statement->fetchAll();
        $users = array();
        foreach ($usersData as $userData) {
            $userId = $userData['id_user'];
            $users[$userId] = $this->buildUser($userData);
        }
        return $users;
    }

    /**
     * Retorna el total de Birthday de la semana|FALSE de caso contrario.
     * $Birthday
     * */
    public function birthDay()
    {
        $queryBuilder = $this->database->createQueryBuilder();
        $queryBuilder
            ->select('u.*')
            ->from('users', 'u')
            ->where('DATE_ADD(u.birth_date, INTERVAL YEAR(CURDATE())-YEAR(u.birth_date)
                     + IF(DAYOFYEAR(CURDATE()) > DAYOFYEAR(u.birth_date),1,0) YEAR)BETWEEN CURDATE()
                     AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                     AND DATE_FORMAT(CURDATE(),\'%d\') = DATE_FORMAT(`birth_date`,\'%d\')');
        $statement = $queryBuilder->execute();
        $birthday = $statement->fetchAll();
        $birthd = array();
        foreach ($birthday as $birthdays) {
            $userid = $birthdays['id_user'];
            $birthd[$userid] = $this->buildUser($birthdays);
        }

        return $birthd;
    }

    /**
     * @param integer $id
     * @return int
     */
    public function delete($id)
    {
        return $this->database->delete('users', array('id_user' => $id));
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $queryBuilder = $this->database->createQueryBuilder();
        $queryBuilder
            ->select('u.*')
            ->from('users', 'u')
            ->where('u.username = :username OR u.mail = :mail')
            ->setParameter('username', $username)
            ->setParameter('mail', $username)
            ->setMaxResults(1);
        $statement = $queryBuilder->execute();
        $usersData = $statement->fetchAll();
        if (empty($usersData)) {
            throw new UsernameNotFoundException(sprintf('El usuario "%s" no se ha encontrado.', $username));
        }
        $user = $this->buildUser($usersData[0]);
        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Las instancias de "%s" no son compatibles.', $class));
        }
        $id = $user->getIdUser();
        $refreshedUser = $this->find($id);
        if (false === $refreshedUser) {
            throw new UsernameNotFoundException(sprintf('Usuario con id "%s"s no encontrado', json_encode($id)));
        }
        return $refreshedUser;
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'bbdo\Entity\User' === $class;
    }

    /**
     * Ejemplariza una entidad usuario, establece sus propiedades utilizando datos db.
     * @param array $userData The array of db data.
     * @return \bbdo\Entity\User
     */
    protected function buildUser($userData)
    {
        $user = new User();
        $user->setIdUser($userData['id_user']);
        $user->setRunUser($userData['run_user']);
        $user->setNameUser($userData['name_user']);
        $user->setLastnameUser($userData['lastname_user']);
        $user->setSecondSurname($userData['second_surname']);
        $user->setUsername($userData['username']);
        $user->setPassword($userData['password']);
        $user->setMail($userData['mail']);
        $user->setSalt($userData['salt']);
        $user->setStatusUser($userData['status_user']);
        $user->setRole($userData['role']);
        $user->setRolePublic($userData['role_public']);
        $birth = new \DateTime($userData['birth_date']);
        $user->setPostUser($userData['post_user']);
        $user->setAreaUser($userData['area_user']);
        $createdAt = new \DateTime($userData['created_at']);
        $startdate = new \DateTime($userData['start_date']);
        $user->setBirthDate($birth);
        $user->setCreatedAt($createdAt);
        $user->setStartDate($startdate);
        $user->setAnnexTelephone($userData['annex_telephone']);
        $user->setPhotoUser($userData['photo_user']);
        return $user;
    }
}
