<?php

declare(strict_types=1);

namespace App\UI\Home;

use App\Controllers\ContactListControl;
use Nette;
use Nette\Application\UI\Form;


class HomePresenter extends Nette\Application\UI\Presenter
{

    public function formAllSucceeded(Form $form, $data): void
    {
        $contacts = new ContactListControl();
        $this->sendJson($contacts->getAllContacts());
    }

    public function formNumberSucceeded(Form $form, $data): void
    {
        $contacts = new ContactListControl();
        $c = $contacts->getDataByPhoneNumber($data['phone_number']) ?
            $contacts->getDataByPhoneNumber($data['phone_number'])
            : ['message' => 'phone number: ' . $data['phone_number'] . ' does not exist.'];
        $this->sendJson($c);
    }

    public function formPersonSucceeded(Form $form, $data): void
    {
        $contacts = new ContactListControl();
        $c = $contacts->getContactDetail($data['surname']) ?
            $contacts->getContactDetail($data['surname'])
            : ['message' => 'person with surname: ' . $data['surname'] . ' does not exist.'];
        $this->sendJson($c);
    }

    public function formNewSucceeded(Form $form, $data): void
    {
        $contacts = new ContactListControl();
        $contacts->addNewContact($data);
        $this->sendJson(['message' => 'new contact has been saved']);
    }

    public function formUpdateSucceeded(Form $form, $data): void
    {
        $contacts = new ContactListControl();
        $contacts->updateContact($data);
        $this->sendJson(['message' => 'contact surname has been changed']);
    }

//    form components

    protected function createComponentAllContacts(): Form
    {
        $form = new Form;
        $form->addSubmit('all', 'Vsechny kontakty');
        $form->setMethod('get');
        $form->onSuccess[] = [$this, 'formAllSucceeded'];
        return $form;
    }

    protected function createComponentGetByNumber(): Form
    {
        $form = new Form;
        $form->addText('phone_number');
        $form->addSubmit('by_number', 'Ziskat kontakt');
        $form->setMethod('get');
        $form->onSuccess[] = [$this, 'formNumberSucceeded'];
        return $form;
    }

    protected function createComponentNewPerson(): Form
    {
        $form = new Form;
        $form->addText('name', 'jmeno');
        $form->addText('surname', 'prijmeni');
        $form->addText('phone_number', 'cislo');
        $form->addSelect('type', 'typ cisla', [2 => 'Domov', 1 => 'Prace']);
        $form->addSubmit('insert_data', 'Uloz kontakt');
        $form->onSuccess[] = [$this, 'formNewSucceeded'];
        return $form;
    }

    protected function createComponentGetPerson(): Form
    {
        $form = new Form;
        $form->addText('surname');
        $form->addSubmit('by_surname', 'Ziskat kontakt');
        $form->setMethod('get');
        $form->onSuccess[] = [$this, 'formPersonSucceeded'];
        return $form;
    }

    protected function createComponentUpdatePerson(): Form
    {
        $contact = new ContactListControl();;
        $form = new Form;
        $form->addSelect('kontakty', 'ulozene', $contact->getActualContact());
        $form->addText('zmena', 'zmenit na');
        $form->addSubmit('by_surname', 'Upravit kontakt');
        $form->setMethod('get');
        $form->onSuccess[] = [$this, 'formUpdateSucceeded'];
        return $form;
    }
}
