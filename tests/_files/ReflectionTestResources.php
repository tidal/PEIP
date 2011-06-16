<?php

interface ReflectionTestInterface1 {

    public function foo();

}

interface ReflectionTestInterface2 {

    public function bar();

}

class ReflectionTestClass1 {

}

class ReflectionTestClass2 extends ReflectionTestClass1 implements ReflectionTestInterface1 {

   public function foo(){}

}

class ReflectionTestClass3 extends ReflectionTestClass2 implements ReflectionTestInterface2 {

   public function bar(){}

}

class ReflectionTestClass4 extends ReflectionTestClass3 {



}