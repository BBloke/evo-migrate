# evo-migrate
EvolutionCMS module for migrating v1.4, v2 to v3.x
Works with PHP 7 only (as yet not tried with PHP 8)

The program does the following:

1. Checks admin user names against current web user names for duplicates
2. Checks admin email addresses against current web email addresses for duplicates
3. Reports any findings that need addressing
4. Transfers any settings and permissions
5. Creates migration_install table for logs
6. Creates permissions table
7. Creates role_permissions table
8. Adds in required system events
9. Creates config file
10. Downloads and installs the new v3 program
11. You must then run install after migration

Issues:
Plugins can prevent you from accessing your site after the migration.  This may be due to the plugins code trying to use the old web user tables.
The best approach I have found is to disable all the plugins prior to migrating.  Re-enabling them one by one and test the site after migration.
Alternatively you can disable them via phpMyAdmin.

My testing was using an old Evo v1.0 site that has been updated during the years.  I duplicated the site and exported the database to a new table. I spent some time altering the schema charset and tables.  This may have been beneficial to the migraton process but as yet, i'm not sure.  More testing is needed with old databases and character sets!

Disclaimer:
This module is offered as-is.  Please make sure you take suitable precautions before running the migration.
Backup up your site files and database first.
Your old manager folder will be deleted as part of the migration.  You will need a copy of it if you make use of any special files inside your manager folder structure.
