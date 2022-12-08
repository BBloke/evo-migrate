# evo-migrate v2
EvolutionCMS module for migrating v1.4, v2 to v3.x
Works with PHP 7 and PHP 8

Tested on v1.4.12 PHP8.0 with users and permissions.
Tested on v2.0.4 PHP7.4 with users and permissions.
	This was v1.4.12 upgraded to v2.0.4.

NB: v2 code is not PHP8 compatible.  This script has only been tested for v2 with PHP7.4

I have refactored the old code to make each process a clickable step utilising AJAX.

The program does the following:

1. Creates new manager group names from web group names
2. Creates a table to import after v3 installation to migrate the new webuser > user group permissions in point 1.
3. Checks admin user names against current web user names for duplicates
4. Checks admin email addresses against current web email addresses for duplicates
5. Reports any findings that need addressing
6. Transfers any settings and permissions
7. Creates migration_install table for logs
8. Creates permissions table
9. Creates role_permissions table
10. Adds in required system events
11. Creates config file
12. Downloads the new v3 program from evolution/evolution-community
13. Run /install to finalise the migration.

# How to Use

Install and run the module.

The program breaks each section down to clickable buttons.

1. Check Users and Emails for duplications.
2. Install new tables
3. Create new System Events
4. Migrate Users
5. Download and extract latest v3 code

Each button will run a process via ajax and return results to the screen.
Each button turns red once clicked

* WAIT UNTIL A RESULT HAS BEEN RETURNED BEFORE CLICKING THE NEXT BUTTON *

Once v3 has downloaded and extracted you will be prompted to click a link to run the install process.

After the install process has run.  Log in to the Manager and re-run the migration tool.

The last process is to import the temporary access table.

## Considerations

You can click the buttons mulitple times and click them out of order.  BE CAREFUL.
Only click them in order and wait until you see the result on the screen.

# Issues:
Plugins can prevent you from accessing your site after the migration.  This may be due to the plugins code trying to use the old web user tables.
The best approach I have found is to disable all the plugins prior to migrating.  Re-enabling them one by one and test the site after migration.
Alternatively you can disable them via phpMyAdmin.

Double check the manager configuration language when saving as I've found it defaulting to BE and not EN in my case.

My testing was using an old Evo v1.0 site that has been updated during the years.  I duplicated the site and exported the database to a new table. I spent some time altering the schema charset and tables.  This may have been beneficial to the migraton process but as yet, i'm not sure.  More testing is needed with old databases and character sets!

# Extra Note:
The DB Engine is also fixed in the config file to "InnoDB".

# Post installation:
If you receive an error regarding table web_user_attributes does not exist then you need to disable 'userHelper' plugin or amend it's model to:
```
Pathologic\EvolutionCMS\MODxAPI\modUsers
```
You will also need to change any FormLister call for user login, regristration etc to include the following:
```
&model=`Pathologic\EvolutionCMS\MODxAPI\modUsers`
```

You will also need to add Pathologic's composer package to core/custom/composer.json (this may be included with the latest version of EvolutionCMS).

** Example
```
{
	"require": {
		"pathologic/modxapi": "*"
	}
}
```

The script makes a backup of webgroup_access table so it can be imported after v3 installation.
Re-run the migration script after v3 installation will offer a button to import.
This puts your old webuser/document resource links.

# Disclaimer:
This module is offered as-is.  Please make sure you take suitable precautions before running the migration.
Backup up your site files and database first.
Your old manager folder will be deleted as part of the migration.  
You will need a copy of it if you make use of any special files inside your manager folder structure.
