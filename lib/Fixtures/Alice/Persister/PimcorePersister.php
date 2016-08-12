<?php


namespace Fixtures\Alice\Persister;


use Nelmio\Alice\PersisterInterface;
use Pimcore\Model\Element\ValidationException;
use Pimcore\Model\Object\AbstractObject;
use Pimcore\Model;
use Pimcore\Model\User\AbstractUser;

class PimcorePersister implements PersisterInterface {


    /**
     * @var bool
     */
    private $ignorePathAlreadyExits;

    /**
     * @param bool $ignorePathAlreadyExits
     */
    public function __construct($ignorePathAlreadyExits = false) {
        $this->ignorePathAlreadyExits = $ignorePathAlreadyExits;
    }


    /**
     * Loads a fixture file
     *
     * @param AbstractObject array [object] $objects instance to persist in the DB
     */
    public function persist(array $objects) {
        foreach ($objects as $object) {
            switch (true) {
                case $object instanceof AbstractObject:
                    $this->persistObject($object);
                    break;
                case $object instanceof AbstractUser:
                    $this->persistUser($object);
                    break;
            }
        }
    }

    /**
     * Finds an object by class and id
     *
     * @param  string|AbstractObject $class
     * @param  int $id
     * @return mixed
     */
    public function find($class, $id) {

        $obj = $class::getById($id);
        if (!$obj) {
            throw new \UnexpectedValueException('Object with Id ' . $id . ' and Class ' . $class . ' not found');
        }

        return $obj;
    }

    /**
     * @param AbstractObject $object
     */
    private function persistObject($object) {
        if ($this->ignorePathAlreadyExits === true) {
            if ($parent = $object->getParent()) {

                $path = str_replace('//', '/', $parent->getFullPath() . '/');
                $object->setPath($path);
            }
            $tmpObject = $object::getByPath($object->getFullPath());
            if ($tmpObject) {
                $object->setId($tmpObject->getId());
            }
        }
        $object->save();
    }

    /**
     * @param AbstractUser $object
     */
    private function persistUser($object) {

        if ($this->ignorePathAlreadyExits === true) {
            $tmpObj = $object::getByName($object->getName());

            if($tmpObj){
                $object->setId($tmpObj->getId());
            }
        }
        $object->save();

    }
}