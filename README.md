Prestashop
==========
1. As we are overriding a controller we need to delete cache/class_index.php
2. Download and install the module.
  
  - copy account_activated.html and account_activated.txt from the mails.zip in mails/
  
  - open controllers/admin/AdminCustomersController.php and modify the following
        
        'align' => 'center',
  
        'active' => 'status', //around line 116
  
        'type' => 'bool',
        
  to 
        
        'align' => 'center',
        
        'callback' => 'printStatusIcon', //around line 116
        
        'type' => 'bool',

NOTE: The override for this function wasn't working so I left this manual modification for now.

        
3. Deactivate automatic activation on account creation.

  To do so you need to modify a little code. In controllers/front/AuthController.php you need to change:
    
        $customer->active = 1; //around line 435
        
   to
   
        $customer->active = 0;
        
  Once you've done this your customers will have a deactivated account when the registration is complete.

        
4. Modify email templates in mails/{lang_code}/account to include the message that the account is not active yet.
