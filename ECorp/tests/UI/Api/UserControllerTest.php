<?php

namespace ECorp\Test\UI\Api;

use ECorp\ECorpRestApiTest;
use GuzzleHttp\RequestOptions;

class UserControllerTest extends ECorpRestApiTest
{
    public function testGetListOfAllUsers()
    {
        $request = $this->httpClient->get(
            UserControllerTest::API_URL.'/api/users'
        );

        $this->assertEquals(200, $request->getStatusCode());
    }

    public function testRegisterUser()
    {
        $request = $this->httpClient->post(
            UserControllerTest::API_URL.'/api/user',
            [
                RequestOptions::JSON => [
                    'email' => 'mkozil@ecorp.com',
                    'age' => 24,
                    'username' => 'Mateusz Kozioł'
                ]
            ]
        );

        $this->assertEquals(201, $request->getStatusCode());
        $this->assertTrue(key_exists('uuid', json_decode($request->getBody())));
    }

    public function testDoNotRegisterUserFromMicrosoft()
    {
        $request = $this->httpClient->post(
            UserControllerTest::API_URL.'/api/user',
            [
                RequestOptions::JSON => [
                    'email' => 'mkozil@microsoft.com',
                    'age' => 24,
                    'username' => 'Mateusz Kozioł'
                ]
            ]
        );

        $this->assertEquals(400, $request->getStatusCode());
        $this->assertEquals('Email could not be from microsoft.com domain.', (json_decode($request->getBody(), true))['payload']);
    }

    public function testDoNotRegisterUserFromOutsideOfEcorpDomain()
    {
        $request = $this->httpClient->post(
            UserControllerTest::API_URL.'/api/user',
            [
                RequestOptions::JSON => [
                    'email' => 'mkozil@somedomain.com',
                    'age' => 24,
                    'username' => 'Mateusz Kozioł'
                ]
            ]
        );

        $this->assertEquals(400, $request->getStatusCode());
        $this->assertEquals('Email has to be from ecorp.com domain.', (json_decode($request->getBody(), true))['payload']);
    }

    public function testDoNotRegisterUserUnder18()
    {
        $request = $this->httpClient->post(
            UserControllerTest::API_URL.'/api/user',
            [
                RequestOptions::JSON => [
                    'email' => 'mkozil@ecorp.com',
                    'age' => 15,
                    'username' => 'Mateusz Kozioł'
                ]
            ]
        );

        $this->assertEquals(400, $request->getStatusCode());
        $this->assertEquals(
            'Age can not be less than 18',
            (json_decode($request->getBody(), true))['payload']
        );
    }

    /**
     * @return array
     */
    public function registerUserProvider(): array
    {
        return [
            [['email' => 'mkoziol@ecorp.com', 'age' => 24, 'username' => 'Mateusz Kozioł'], 201],
            [['email' => 'mkoziol@ecorp.com', 'age' => 18, 'username' => 'SuperRegisteredUser'], 201],
            [['email' => 'mkoziol@ecorp.com', 'age' => 18, 'username' => ''], 400],
            [['email' => 'mkoziol@ecorp.com', 'age' => 15, 'username' => 'Mateusz Kozioł'], 400],
            [['email' => 'isthisokemail?', 'age' => 25, 'username' => 'Mateusz Kozioł'], 400],
        ];
    }

    /**
     * @dataProvider registerUserProvider
     * @param array $userData
     * @param int $expectedResultCode
     */
    public function testRegisterUserFromDifferentData(array $userData, int $expectedResultCode)
    {
        $request = $this->httpClient->post(
            UserControllerTest::API_URL.'/api/user',
            [
                RequestOptions::JSON => $userData
            ]
        );

        $this->assertEquals($expectedResultCode, $request->getStatusCode());
    }
}
