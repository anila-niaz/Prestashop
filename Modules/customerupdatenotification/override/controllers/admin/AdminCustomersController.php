<?php

class AdminCustomersController extends AdminCustomersControllerCore
{
	public function initProcess()
    {
        parent::initProcess();

        if (Tools::isSubmit('submitGuestToCustomer') && $this->id_object)
        {
            if ($this->tabAccess['edit'] === '1')
                $this->action = 'guest_to_customer';
            else
                $this->errors[] = Tools::displayError('You do not have permission to edit this.');
        }
        elseif (Tools::isSubmit('changeNewsletterVal') && $this->id_object)
        {
            if ($this->tabAccess['edit'] === '1')
                $this->action = 'change_newsletter_val';
            else
                $this->errors[] = Tools::displayError('You do not have permission to edit this.');
        }
        elseif (Tools::isSubmit('changeOptinVal') && $this->id_object)
        {
            if ($this->tabAccess['edit'] === '1')
                $this->action = 'change_optin_val';
            else
                $this->errors[] = Tools::displayError('You do not have permission to edit this.');
        }
        elseif (Tools::isSubmit('changeStatusVal') && $this->id_object)
                {
                    if ($this->tabAccess['edit'] === '1')
                        $this->action = 'change_status_val';
                    else
                        $this->errors[] = Tools::displayError('You do not have permission to edit this.');
                }

        // When deleting, first display a form to select the type of deletion
        if ($this->action == 'delete' || $this->action == 'bulkdelete')
            if (Tools::getValue('deleteMode') == 'real' || Tools::getValue('deleteMode') == 'deleted')
                $this->delete_mode = Tools::getValue('deleteMode');
            else
                $this->action = 'select_delete';
    }

    public function processChangeStatusVal()
    {
        $customer = new Customer($this->id_object);
        if (!Validate::isLoadedObject($customer))
            $this->errors[] = Tools::displayError('An error occurred while updating customer information.');
        $customer->active = $customer->active ? 0 : 1;
        if (!$customer->update())
            $this->errors[] = Tools::displayError('An error occurred while updating customer information.');
        if($customer->active == 1)
        {

             Mail::Send(
                $this->context->language->id,
                'account_activated',
                Mail::l('Welcome!'),
                array(
                    '{firstname}' => $customer->firstname,
                    '{lastname}' => $customer->lastname,
                    '{email}' => $customer->email,
                    '{shopname}' => $this->context->shop->name,),
                $customer->email,
                $customer->firstname.' '.$customer->lastname,
            );
        }
        Tools::redirectAdmin(self::$currentIndex.'&token='.$this->token);
    }

    public static function printStatusIcon($value, $customer)
    {
        return '<a href="index.php?tab=AdminCustomers&id_customer='
            .(int)$customer['id_customer'].'&changeStatusVal&token='.Tools::getAdminTokenLite('AdminCustomers').'">
                '.($value ? '<img src="../img/admin/enabled.gif" />' : '<img src="../img/admin/disabled.gif" />').
            '</a>';
    }
}


