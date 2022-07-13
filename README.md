# evo-migrate
EvolutionCMS module for migrating v1.4, v2 to v3.x

This is currently incomplete.

The program does the following:

1. Checks admin user names against current web user names for duplicates
2. Checks admin email addresses against current web email addresses for duplicates
3. Reports any findings that need addressing

TODO - Write the code to handle the necessary user and setting migrations.

program intentionally terminates at this point

4. Creates migration_install table for logs
5. Creates permissions table
6. Creates role_permissions table
7. Adds in required system events
8. Creates config file

code is intentionally commented out.

9. Downloads and installs the new v3 program
10. You must then run install

