<?php

namespace PMT\WebBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AjaxControllerTest extends WebTestCase
{
    protected $client;

    public function testTagsFirewall()
    {
        $client = static::createClient();
        $client->request('POST', '/ajax/tags.json');
        $this->assertContains('/login', $client->getResponse()->headers->get('location'));
    }

    public function testTags()
    {
        $client = $this->getLoggedInClient();
        $client->request('POST', '/ajax/tags.json');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'content-type',
                'application/json'
            )
        );

        $array = (array)json_decode($client->getResponse()->getContent());
        $this->assertTrue(array_key_exists('tags', $array));
    }

    public function testMilestonesFirewall()
    {
        $client = static::createClient();
        $client->request('POST', '/ajax/milestones.json');
        $this->assertContains('/login', $client->getResponse()->headers->get('location'));
    }

    public function testMilestones()
    {
        $client = $this->getLoggedInClient();
        $client->request('POST', '/ajax/milestones.json');

        $this->assertTrue(
            $client->getResponse()->headers->contains(
                'content-type',
                'application/json'
            )
        );

        $array = (array)json_decode($client->getResponse()->getContent());
        $this->assertTrue(array_key_exists('milestones', $array));
    }

    protected function getLoggedInClient()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form(
            array(
                '_username' => getenv('PMTWEB_AUTH_USER'),
                '_password' => getenv('PMTWEB_AUTH_PASSWORD'),
            )
        );
        $client->submit($form);
        $client->followRedirect();

        return $client;
    }
}
