# Formbuilder

Formbuilder is a Iris library for generating forms. Useless if you don't use Iris CMS.

## Installation
1. Run command:
```bash
composer require "themindoffice/formbuilder" @dev
```
*(Stable version coming soon)*


2. Copy 'vendor/themindoffice/formbuilder/src/' to 'modules/Addons'
3. Go to your-local-domain.test/formbuilder/install
> This function add the needed tables and components.
4. 'modules/Addons/Formbuiler/install' will be deleted automatically
5. Remove method 'install' form 'modules/Addons/Formbuiler' manually

## Usage

1. Use the code below in your HTML:

```python
<?= form(1)
    ->useBootstrap(5)
    ->addColumnClass('mb-3')
    ->addButtonClass('btn btn-green')
    ->showLabel(true)
    ->html(); ?>
```

2. Add this in your .env file with the right credentials. Make sure the domain is whitelisted at Mandrill.
```
MAIL_FROM_ADDRESS=example@mail.com
MAIL_FROM_NAME="Example"
```