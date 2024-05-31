<?php

namespace App\Controllers;

use Nette\Application\UI\Control;
use Nette\Database\Connection;

class ContactListControl extends Control
{
    private $db;

    public function __construct()
    {
        $this->db = new Connection("mysql:host=mysql-service;dbname=phoneList_db", "root", "neconeco123");
    }

    public function getAllContacts()
    {
        $result = [];
        $data = $this->db->fetchAll('select * from Persons per');
        foreach ($data as $d) {
            $result[$d['ID']] = [
                'name' => $d['NAME'],
                'surname' => $d['SURNAME']
            ];
        }
        return $result;
    }

    public function getDataByPhoneNumber($number)
    {
        $result = [];
        $data = $this->db->query(
            'select per.NAME, per.SURNAME from Numbers pho
                join Persons per ON per.ID = pho.PERSON_ID
                where pho.PHONE_NUMBER = ?', $number);
        foreach ($data as $d) {
            $result[] = [
                'name' => $d['NAME'],
                'surname' => $d['SURNAME']
            ];
        }
        return $result;
    }

    public function getContactDetail($surname)
    {
        $result = [];
        $data = $this->db->query(
            'select per.NAME, per.SURNAME, pho.PHONE_NUMBER, typ.NAME as PHONE_TYPE from Numbers pho
                join Persons per ON per.ID = pho.PERSON_ID
                join Types typ on typ.ID = pho.TYPE_ID 
                where per.SURNAME = ?', $surname);

        foreach ($data as $d) {
            $result[] = [
                'name' => $d['NAME'],
                'surname' => $d['SURNAME'],
                'phoneNumber' => $d['PHONE_NUMBER'],
                'type' => $d['PHONE_TYPE']
            ];
        }
        return $result;
    }

    public function addNewContact($contact)
    {
        $this->db->query(
            'INSERT INTO phoneList_db.Persons
                (NAME, SURNAME)
                VALUES(?, ?)', $contact['name'], $contact['surname']);

        $this->db->query('
                INSERT INTO phoneList_db.Numbers
                (PHONE_NUMBER, PERSON_ID, TYPE_ID)
                VALUES(?, ?, ?)', $contact['phone_number'], $this->db->getInsertId(), $contact['type']);

    }

    public function updateContact($conract)
    {
        $this->db->query('
            UPDATE phoneList_db.Persons
            SET SURNAME=?
            WHERE ID=?', $conract['zmena'], $conract['kontakty']);
    }

    public function getActualContact()
    {
        $result = [];
        $data = $this->db->fetchAll('select per.ID, per.SURNAME from Persons per');
        foreach ($data as $d) {
            $result[$d['ID']]  = $d['SURNAME'];
        }
        return $result;
    }

}