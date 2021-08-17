<?php

namespace App\Tests\Repository;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    public function testCount(){
        self::bootKernel();
        self::$container->get(UsersRepository::class)->count([]);
        $this->assertEquals(10, $users);
    }
}