<?php

class PEIP_Object_Storage
    extends SplObjectStorage{}
class PEIP_Object_Storage2
    extends SplObjectStorage
    implements
        Countable,
        Iterator,
        Traversable,
        Serializable,
        ArrayAccess {

	protected 
        $objects = array(),
        $values = array(),
        $objectsNr = 0,
        $arrayIterator = NULL;

	public function attach($object, $data = NULL){
		return $this->offsetSet($object, $data);		
	}

	public function offsetSet2($offset, $value){
		$this->objects[$this->objectsNr] = $offset;
		$this->values[$this->objectsNr] = $value;
        $this->objectsNr++;
	}

	public function offsetGet2($offset){
            if(in_array($offset, $this->objects)){
                $key = array_search($offset, $this->objects);
                return $this->values[$key];
            }
	}

	public function offsetUnset($offset){
        if(in_array($offset, $this->objects)){
            $key = array_search($offset, $this->objects);
            unset($this->values[$key]);
            unset($this->objects[$key]);
        }
	}

	public function offsetExists($offset){
        $res = in_array($offset, $this->objects);
        return $res;      
	}

    public function count(){
        return count($this->objects);
    }

    public function rewind(){
        return $this->getArrayIterator()->rewind();
    }

    public function next(){
        return $this->getArrayIterator()->next();
    }

    public function current(){
        return $this->getArrayIterator()->current();
    }

    public function valid(){
        return $this->getArrayIterator()->valid();
    }

    public function key(){
        return $this->getArrayIterator()->key();
    }

    public function getInfo(){
        return $this->offsetGet($this->getArrayIterator()->current());
    }

    public function addAll ($storageSplObjectStorage){
        $storageSplObjectStorage->rewind();
        while($storageSplObjectStorage->valid()){
            $this->offsetSet(
                $storageSplObjectStorage->current(),
                $storageSplObjectStorage->getInfo()
            );
            $storageSplObjectStorage->next();
        }
    }

    public function removeAll ($storageSplObjectStorage){
        $storageSplObjectStorage->rewind();
        while($storageSplObjectStorage->valid()){
            if($this->offsetExists($storageSplObjectStorage->current())){
                $this->offsetUnset($storageSplObjectStorage->current());
            }
            $storageSplObjectStorage->next();
        }
    }

    public function contains($object){
        return $this->offsetExists($object);
    }

    protected function getArrayIterator(){
        return $this->arrayIterator instanceof Iterator 
            ? $this->arrayIterator
            : $this->arrayIterator = new ArrayIterator($this->objects);
    }

}

