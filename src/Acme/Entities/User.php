<?php
 
namespace Acme\Entities;
 
/**
 * @Entity
 */
class User
{
    /**
     * @Id
     * @Table(name="user")
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;
   
    /**
     * @Column(type="string")
     */
    private $name;
   
    public function getId()
    {
        return $this->id;
    }
   
    public function getName()
    {
        return $this->name;
    }
   
    public function setName($name)
    {
        $this->name = $name;
    }
}

