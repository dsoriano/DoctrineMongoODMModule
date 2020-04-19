<?php
namespace DoctrineMongoODMModule\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Connection options for doctrine mongo
 *
 * @license MIT
 * @link    http://www.doctrine-project.org/
 * @since   0.1.0
 * @author  Tim Roediger <superdweebie@gmail.com>
 */
class Connection extends AbstractOptions
{

    /**
     * The server with the mongo instance you want to connect to
     *
     * @var string
     */
    protected $server = 'localhost';

    /**
     * Port to connect over
     *
     * @var string
     */
    protected $port = '27017';

    /**
     * Username if using mongo auth
     *
     * @var string
     */
    protected $user = null;

    /**
     * Password if using mongo auth
     *
     * @var string
     */
    protected $password = null;

    /**
     * If you want to connect to a specific database
     *
     * @var string
     */
    protected $dbname = null;

    /**
     * If you want to provide a custom connection string
     *
     * @var string
     */
    protected $connectionString = null;

    /**
     * Further connection options defined by mongodb-odm
     *
     * @var array
     */
    protected $options = [];

    /**
     *
     * @return string
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     *
     * @param string $server
     *
     * @return Connection
     */
    public function setServer($server)
    {
        $this->server = (string)$server;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     *
     * @param string $port
     *
     * @return Connection
     */
    public function setPort($port)
    {
        $this->port = (string)$port;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     *
     * @param string $user
     *
     * @return Connection
     */
    public function setUser($user)
    {
        $this->user = (string)$user;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     *
     * @param string $password
     *
     * @return Connection
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getDbname()
    {
        return $this->dbname;
    }

    /**
     *
     * @param string $dbname
     *
     * @return Connection
     */
    public function setDbname($dbname)
    {
        $this->dbname = (string)$dbname;
        return $this;
    }

    /**
     *
     * @return string
     */
    public function getConnectionString()
    {
        return $this->connectionString;
    }

    /**
     *
     * @param string $connectionString
     *
     * @return Connection
     */
    public function setConnectionString($connectionString)
    {
        $this->connectionString = (string)$connectionString;
        return $this;
    }

    /**
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     *
     * @param array $options
     *
     * @return Connection
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }
}
