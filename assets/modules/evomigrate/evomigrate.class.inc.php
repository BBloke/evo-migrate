<?php

class evoMigrate
{	
	static public function initiate () {
		$modx = EvolutionCMS();
		
		$output = '';
		$tempWebGroupAccess = 'tempwebgroup_access';
		
		$_REQUEST['action'] ??= '';
		$action_id = isset($_GET['a']) 		? intval($_GET['a']) 	: 0;
		$module_id = isset($_GET['id']) 	? intval($_GET['id']) 	: 0;
		
		// We have updated to 3
		if ( substr($modx->getConfig('settings_version'),0,1) > 2 ) {
			if ( $_REQUEST['action'] == 'Reactivate Plugins' ) {
				$output .= "Reactivating Plugins<br />";
				evoMigrate::activatePlugins();
			} else {
				$output .=  "Do you want to import the old webgroup_access table in the current usergroup_access table.<br />";
				$output .=  "<form>";
				//$output .=  "<a href='#&action=run' title='run' class='btn'>Run</a>";
				$output .=  '<input type="hidden" name="a" value="'.$action_id.'"/>';
				$output .=  '<input type="hidden" name="id" value="'.$module_id.'"/>';
				$output .=  "<input type='submit' name='action' value='Reactivate Plugins' class='btn'>";
				$output .=  "</form>";
				$output .= "Converting Permissions to WEB from MGR.<br />";
				
				$fields = array( 'context' => 1 );
				$modx->db->update($fields, $modx->getFullTableName('membergroup_access'), "context=0" );
			}
			return $output;
			
			//die("You are already on v3 or above.");
		}
		
		$output = "<table class='myTable'>";
			$output .= "<thead>";
				$output .= "<tr>";
					$output .= "<th width='45%'>Function</th>";
					$output .= "<th width='10%'>Action</th>";
					$output .= "<th width='45%'>Result</th>";
				$output .= "</tr>";
			$output .= "</thead>";
			$output .= "<tbody>";
				$output .= "<tr>";
					$output .= "<td>Disable active Plugins?</td>";
					$output .= "<td><input id='deactivatePlugins' type='submit' name='deactivatePlugins' value='Deactivate Plugins' /></td>";
					$output .= "<td><div id='deactivatePluginsResult'></div></td>";
				$output .= "</tr>";
				$output .= "<tr>";
					$output .= "<td>Check Users and Email Address for Duplicate</td>";
					$output .= "<td><input id='checkUsers' type='submit' name='checkUsers' value='Check Users' /></td>";
					$output .= "<td><div id='checkUsersResult'></div></td>";
				$output .= "</tr>";
				
				$output .= "<tr>";
					$output .= "<td>Install New Tables migrations_install, permission_groups, permissions, role_permissions<br />";
					$output .= "(This may take upto 5 mins to complete.)</td>";
					$output .= "<td><input id='installTables' type='submit' name='installTables' value='Install Tables' /></td>";
					$output .= "<td><div id='installTablesResult'></div></td>";
				$output .= "</tr>";
				
				$output .= "<tr>";
					$output .= "<td>Setup New System Events</td>";
					$output .= "<td><input id='systemEvents' type='submit' name='systemEvents' value='Setup System Events' /></td>";
					$output .= "<td><div id='systemEventsResult'></div></td>";
				$output .= "</tr>";
				
				$output .= "<tr>";
					$output .= "<td>Migrate Users</td>";
					$output .= "<td><input id='migrateUsers' type='submit' name='migrateUsers' value='Migrate Users' /></td>";
					$output .= "<td><div id='migrateUsersResult' style='overflow:scroll;height: 100px;'></div></td>";
				$output .= "</tr>";
				
				$output .= "<tr>";
					$output .= "<td>Download and install v3</td>";
					$output .= "<td><input id='installv3' type='submit' name='installv3' value='Install v3' /></td>";
					$output .= "<td><div id='installv3Result'></div></td>";
				$output .= "</tr>";
				
			$output .= "</tbody>";
		$output .= "</table>";
		
		$output .= '<script src="media/script/jquery/jquery.min.js" type="text/javascript"></script>';
		$output .= '<script type="text/javascript">
						var url =  "../assets/modules/evomigrate/ajax/evomigrate.ajax.inc.php";

						$("#deactivatePlugins").click(function () {
							$.ajax({
								url			: url,
								type		: "POST",
								cache		: false,
								data		: {
									"action" 		: "deactivatePlugins"
								},
								success		: function( html ) {
									$("#deactivatePluginsResult").append(html);
									$("#deactivatePlugins").css( "background-color", "red" );
								}	// End if success function
							});
							
							return false;
						});
						
						$("#activatePlugins").click(function () {
							$.ajax({
								url			: url,
								type		: "POST",
								cache		: false,
								data		: {
									"action" 		: "activatePlugins"
								},
								success		: function( html ) {
									$("#checkUsersResult").append(html);
									$("#checkUsers").css( "background-color", "red" );
								}	// End if success function
							});
							
							return false;
						});
						
						$("#checkUsers").click(function () {
							$.ajax({
								url			: url,
								type		: "POST",
								cache		: false,
								data		: {
									"action" 		: "checkUsers"
								},
								success		: function( html ) {
									$("#checkUsersResult").append(html);
									$("#checkUsers").css( "background-color", "red" );
								}	// End if success function
							});
							
							return false;
						});
						
						$("#installTables").click(function () {
							$.ajax({
								url			: url,
								type		: "POST",
								cache		: false,
								data		: {
									"action" 		: "installTables"
								},
								success		: function( html ) {
									$("#installTablesResult").append(html);
									$("#installTables").css( "background-color", "red" );
								}	// End if success function
							});
							
							return false;
						});
						
						$("#systemEvents").click(function () {
							$.ajax({
								url			: url,
								type		: "POST",
								cache		: false,
								data		: {
									"action" 		: "systemEvents"
								},
								success		: function( html ) {
									$("#systemEventsResult").append(html);
									$("#systemEvents").css( "background-color", "red" );
								}	// End if success function
							});
							
							return false;
						});
						
						$("#migrateUsers").click(function () {
							$.ajax({
								url			: url,
								type		: "POST",
								cache		: false,
								data		: {
									"action" 		: "migrateUsers"
								},
								success		: function( html ) {
									$("#migrateUsersResult").append(html);
									$("#migrateUsers").css( "background-color", "red" );
								}	// End if success function
							});
							
							return false;
						});
						
						$("#installv3").click(function () {
							$.ajax({
								url			: url,
								type		: "POST",
								cache		: false,
								data		: {
									"action" 		: "installv3"
								},
								success		: function( html ) {
									$("#installv3Result").append(html);
									$("#installv3").css( "background-color", "red" );
								}	// End if success function
							});
							
							return false;
						});
					</script>';
					
		if ( empty($_REQUEST['action']) ) {
			// If we haven't said run don't do anything.
			$output .= '<hr />';
			$output .=  "Please ensure you backup your files and database before proceeding.<br />";
			$output .=  "This program will attempt to migrate you webusers and groups to v3<br />";
			
			$output .=  "The below output is a precursor to the migration.<br />";
			$output .=  "1. Click each button ONE AT A TIME.<br/>";
			$output .=  "2. A button will turn RED when that stage is complete.<br />";
			$output .=  "3. Re-run this module to import the original user/group permissions.<br />";
			
			$output .=  "<br />Checking if Users/Permissions are present.<br/ >";
			$rs = $modx->db->select("username", $modx->getFullTableName('web_users'), "", "id DESC" );
			$userCount = $modx->db->getRecordCount($rs);
			$output .=  "Users found: ".$userCount."<br />";
			$rs = $modx->db->select("name", $modx->getFullTableName('webgroup_names'), "", "id DESC" );
			$nameCount = $modx->db->getRecordCount($rs);
			$output .=  "Permissions found: ".$nameCount."<br />";
			
			
			
		} else {
			$output .=  "<strong>No Users or Permissions found.  Temporary table not needed.</strong>";
		}
		
		return $output;
	}
	
	static public function checkUsers() {
		$modx = EvolutionCMS();
		
		$count = 0;
		$checkUsername = 0;
		$checkEmail = 0;
		$output = 'No User names or Email Address conflicts.';
		
		// USER MIGRATION //
		// Get all the manager users
		$rsUsers = $modx->db->select( "username", $modx->getFullTableName('manager_users') );
		while ( $row= $modx->db->getRow($rsUsers) ) {
			$usernames[] = $row['username'];
		}

		// Get all the manager user attributes
		$rs = $modx->db->select( "email", $modx->getFullTableName('user_attributes') );
		while ( $row= $modx->db->getRow($rs)) {
			$emails[] = $row['email'];
		}

		// Check all the users against the manager users for duplicate USERNAME
		foreach ( $usernames as $username ) {
			$rs = $modx->db->select("username", $modx->getFullTableName('web_users'), "username='".$username."'" );
			$checkUsername = $checkUsername + $modx->db->getRecordCount($rs);
		}

        // Check all the users against the manager users for duplicate email
        foreach ( $emails as $email ) {
            $rsEml = $modx->db->select("email", $modx->getFullTableName('web_user_attributes'), "email='".$email."'" );
            $checkEmail = $checkEmail + $modx->db->getRecordCount($rsEml);
        }
		// Output results
		// If there are duplicates EXIT
		if ($checkUsername > 0 || $checkEmail > 0) {
            $output = '<b>some conflicts are found</b><br/>';
			if ( $checkUsername > 0 ) {
				$output .=  'some manager conflict with web user - It is a good idea to change the WEB USER name only';
				$output .=  '<table border="1"><thead><th>Manager Id</th><th>Manager username</th><th>Web User Id</th><th>Web user username</th></thead><tbody></tbody>';

				// We go through web user
				$sql = "SELECT t1.id as userid, t1.username as username, t2.id as webid, t2.username as webname 
						FROM ".$modx->getFullTableName('manager_users')." t1 
						LEFT JOIN ".$modx->getFullTableName('web_users')." t2 ON t1.username = t2.username
						having t1.username IN (SELECT t2.username from ".$modx->getFullTableName('web_users').");";
				$rs = $modx->db->query($sql);
				
				while ( $row = $modx->db->getRow($rs)) {
					$output .=  '<tr><td>' . $row['userid'] . '</td><td>' . $row['username'] . '</td><td>' . $row['webid'] . '</td><td>' . $row['webname'] . '</td></tr>';
				}
				$output .=  '</tbody></table>';
			}
			
			if ( $checkEmail > 0 ) {
                $output .=  'some manager conflict with web user - It is a good idea to change  user email';
				$output .=  '<table border="1"> <thead><th>Manager Id</th><th>Manager email</th><th>Web User Id</th><th>Web user email</th></thead><tbody></tbody>';
				
				$sql = "SELECT t1.internalKey as userid, t1.email as email, t2.internalKey as webid, t2.email as webemail 
						FROM ".$modx->getFullTableName('user_attributes')."  t1 
						LEFT JOIN ".$modx->getFullTableName('web_user_attributes')." t2 ON t1.email = t2.email
						HAVING t1.email IN (SELECT t2.email FROM ".$modx->getFullTableName('web_user_attributes')." );";
				
				
				$rs = $modx->db->query($sql);
				while ( $row= $modx->db->getRow($rs)) {
					$output .=  '<tr><td>' . $row['internalKey'] . '</td><td>' . $row['email'] . '</td><td>' . $row['webid'] . '</td><td>' . $row['webemail'] . '</td></tr>';
				}
				$output .=  '</tbody></table>';
			}
			exit($output);
		}
		
		return $output;
		
	}
	
	static public function deactivatePlugins() {
		// Get a list of disabled plugins
		$modx = EvolutionCMS();
		$data = '';
		$base_dir = $modx->config['base_path'];
		$results = $modx->db->select("id", $modx->db->config['table_prefix']."site_plugins", 'disabled=0');
		while ( $row = $modx->db->getRow($results) ) {
			//echo $row['id'];
			$data .= $row['id'].',';
			
		}
		$data = rtrim($data, ',');
		
		$sql = "UPDATE ". $modx->db->config['table_prefix']."site_plugins" ." SET disabled=1 WHERE id IN ( ".$data." );";
		$modx->db->query($sql);
		
		// Write it out to an SQL Statement and store in a file.
		file_put_contents($base_dir.'/assets/cache/plugins.txt', $data);
		
		return $data;
	}
	
	static public function activatePlugins() {
		$modx = EvolutionCMS();
		$base_dir = $modx->config['base_path'];
		$data = file_get_contents($base_dir.'/assets/cache/plugins.txt', $data);
		
		$pluginIDs = explode(",", $data);
		
		foreach ( $pluginIDs as $id ) {
			// get the plugin details
			$sql = "SELECT name FROM ".$modx->db->config['table_prefix']."site_plugins" ." WHERE id = ".$id.";";
			$rs = $modx->db->query($sql);
			$row = $modx->db->getRow($rs);
			
			$sql = "SELECT id FROM ".$modx->db->config['table_prefix']."site_plugins" ." WHERE name = '".$row['name']."';";
			$rs = $modx->db->query($sql);
			$count = $modx->db->getRecordCount($rs);
			
			if ( $count > 1 ) {
				// Delete the lowest plugin ID number that has the same name.
				$deleteSQL = "DELETE FROM ".$modx->db->config['table_prefix']."site_plugins" ." WHERE name='".$row['name']."' AND id = ".$id." ORDER BY id ASC LIMIT 1;";
				$delete = $modx->db->query($deleteSQL);
			}
		}
		$sql = "UPDATE ". $modx->db->config['table_prefix']."site_plugins" ." SET disabled=0 WHERE id IN ( ".$data." )";
		$modx->db->query($sql);
		return $data;
	}
	
	static public function installTables () {
		$modx = EvolutionCMS();
		
		$output = '';
		
		// MIGRATION INSTALL //
		$rs = $modx->db->query("SHOW TABLES LIKE '".$modx->db->config['table_prefix']."migrations_install';");
		$count = $modx->db->getRecordCount($rs);
		if ( $count == 0 ) {

			$sql = "DROP TABLE IF EXISTS " . $modx->db->config['table_prefix']."migrations_install;";
			$modx->db->query($sql);
			$sql = "

		CREATE TABLE `" . $modx->db->config['table_prefix']."migrations_install` (
		  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
		  `migration` varchar(255) NOT NULL,
		  `batch` int(11) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
			$modx->db->query($sql);

			$sql2 = "

		INSERT INTO `". $modx->db->config['table_prefix']."migrations_install` (`id`, `migration`, `batch`) VALUES
		(1,	'2018_06_29_182342_create_active_user_locks_table',	1),
		(2,	'2018_06_29_182342_create_active_user_sessions_table',	1),
		(3,	'2018_06_29_182342_create_active_users_table',	1),
		(4,	'2018_06_29_182342_create_categories_table',	1),
		(5,	'2018_06_29_182342_create_document_groups_table',	1),
		(6,	'2018_06_29_182342_create_documentgroup_names_table',	1),
		(7,	'2018_06_29_182342_create_event_log_table',	1),
		(8,	'2018_06_29_182342_create_manager_log_table',	1),
		(9,	'2018_06_29_182342_create_manager_users_table',	1),
		(10,	'2018_06_29_182342_create_member_groups_table',	1),
		(11,	'2018_06_29_182342_create_membergroup_access_table',	1),
		(12,	'2018_06_29_182342_create_membergroup_names_table',	1),
		(13,	'2018_06_29_182342_create_site_content_table',	1),
		(14,	'2018_06_29_182342_create_site_htmlsnippets_table',	1),
		(15,	'2018_06_29_182342_create_site_module_access_table',	1),
		(16,	'2018_06_29_182342_create_site_module_depobj_table',	1),
		(17,	'2018_06_29_182342_create_site_modules_table',	1),
		(18,	'2018_06_29_182342_create_site_plugin_events_table',	1),
		(19,	'2018_06_29_182342_create_site_plugins_table',	1),
		(20,	'2018_06_29_182342_create_site_snippets_table',	1),
		(21,	'2018_06_29_182342_create_site_templates_table',	1),
		(22,	'2018_06_29_182342_create_site_tmplvar_access_table',	1),
		(23,	'2018_06_29_182342_create_site_tmplvar_contentvalues_table',	1),
		(24,	'2018_06_29_182342_create_site_tmplvar_templates_table',	1),
		(25,	'2018_06_29_182342_create_site_tmplvars_table',	1),
		(26,	'2018_06_29_182342_create_system_eventnames_table',	1),
		(27,	'2018_06_29_182342_create_system_settings_table',	1),
		(28,	'2018_06_29_182342_create_user_attributes_table',	1),
		(29,	'2018_06_29_182342_create_user_roles_table',	1),
		(30,	'2018_06_29_182342_create_user_settings_table',	1),
		(31,	'2018_06_29_182342_create_web_groups_table',	1),
		(32,	'2018_06_29_182342_create_web_user_attributes_table',	1),
		(33,	'2018_06_29_182342_create_web_user_settings_table',	1),
		(34,	'2018_06_29_182342_create_web_users_table',	1),
		(35,	'2018_06_29_182342_create_webgroup_access_table',	1),
		(36,	'2018_06_29_182342_create_webgroup_names_table',	1);";

			$modx->db->query($sql2);

			$output .=  time()." Created migrations_install!<br />";
		}
		// END MIGRATION INSTALL //

		// PERMISSIONS GROUP //
		// Create permissions_groups
		$rs = $modx->db->query("SHOW TABLES LIKE '".$modx->db->config['table_prefix']."permissions_groups';");
		$count = $modx->db->getRecordCount($rs);
		if ( $count == 0 ) {

			
			$sql = "
			
			CREATE TABLE `".$modx->db->config['table_prefix']."permissions_groups` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
		  `lang_key` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
		  `created_at` timestamp NULL DEFAULT NULL,
		  `updated_at` timestamp NULL DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;";
			$modx->db->query($sql);

			$fields = array( 
						'migration' => '2018_06_29_182342_create_permissions_groups_table', 
						'batch' => 1
						);
			$modx->db->insert($fields,  $modx->db->config['table_prefix']."migrations_install" );
			
			
			$sql2 = "

			INSERT INTO " .  $modx->db->config['table_prefix']."permissions_groups (`id`, `name`, `lang_key`) VALUES
				(1, 'General', 'page_data_general'),
				(2, 'Content Management', 'role_content_management'),
				(3, 'File Management', 'role_file_management'),
				(4, 'Category Management', 'category_management'),
				(5, 'Module Management', 'role_module_management'),
				(6, 'Template Management', 'role_template_management'),
				(7, 'Snippet Management', 'role_snippet_management'),
				(8, 'Chunk Management', 'role_chunk_management'),
				(9, 'Plugin Management', 'role_plugin_management'),
				(10, 'User Management', 'role_user_management'),
				(11, 'Permissions', 'role_udperms'),
				(12, 'Role Management', 'role_role_management'),
				(13, 'Events Log Management', 'role_eventlog_management'),
				(14, 'Config Management', 'role_config_management')";
				
			$modx->db->query($sql2);
			$output .=  time()." Created permissions_group!<br />";
		}
		// END PERMISSIONS GROUP //

		// PERMISSION //
		// Create permissions Table
		$rs = $modx->db->query("SHOW TABLES LIKE '".$modx->db->config['table_prefix']."permissions';");
		$count = $modx->db->getRecordCount($rs);
		
		if ( $count == 0 ) {
			$sql = "
			
			CREATE TABLE `". $modx->db->config['table_prefix']."permissions` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
		  `key` varchar(255) CHARACTER SET latin1 NOT NULL,
		  `lang_key` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
		  `group_id` int(11) DEFAULT NULL,
		  `disabled` int(11) DEFAULT NULL,
		  `created_at` timestamp NULL DEFAULT NULL,
		  `updated_at` timestamp NULL DEFAULT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;";

			$modx->db->query($sql);
			
			$fields = ['migration' => '2018_06_29_182342_create_permissions_table', 'batch' => 1];
			$modx->db->insert($fields,  $modx->db->config['table_prefix']."migrations_install" );
			
			
			
			$insertArray = [
				['name' => 'Request manager frames', 'lang_key' => 'role_frames', 'key' => 'frames', 'disabled' => 1, 'group_id' => 1],
				['name' => 'Request manager intro page', 'lang_key' => 'role_home', 'key' => 'home', 'disabled' => 1, 'group_id' => 1],
				['name' => 'Log out of the manager', 'lang_key' => 'role_logout', 'key' => 'logout', 'disabled' => 1, 'group_id' => 1],
				['name' => 'View help pages', 'lang_key' => 'role_help', 'key' => 'help', 'disabled' => 0, 'group_id' => 1],
				['name' => 'View action completed screen', 'lang_key' => 'role_actionok', 'key' => 'action_ok', 'disabled' => 1, 'group_id' => 1],
				['name' => 'View error dialog', 'lang_key' => 'role_errors', 'key' => 'error_dialog', 'disabled' => 1, 'group_id' => 1],
				['name' => 'View the about page', 'lang_key' => 'role_about', 'key' => 'about', 'disabled' => 1, 'group_id' => 1],
				['name' => 'View credits', 'lang_key' => 'role_credits', 'key' => 'credits', 'disabled' => 1, 'group_id' => 1],
				['name' => 'Change password', 'lang_key' => 'role_change_password', 'key' => 'change_password', 'disabled' => 0, 'group_id' => 1],
				['name' => 'Save password', 'lang_key' => 'role_save_password', 'key' => 'save_password', 'disabled' => 0, 'group_id' => 1],
				['name' => 'View a Resources data', 'key' => 'view_document', 'lang_key' => 'role_view_docdata', 'disabled' => 1, 'group_id' => 2],
				['name' => 'Create new Resources', 'key' => 'new_document', 'lang_key' => 'role_create_doc', 'disabled' => 0, 'group_id' => 2],
				['name' => 'Edit a Resource', 'key' => 'edit_document', 'lang_key' => 'role_edit_doc', 'disabled' => 0, 'group_id' => 2],
				['name' => 'Change Resource-Type', 'key' => 'change_resourcetype', 'lang_key' => 'role_change_resourcetype', 'disabled' => 0, 'group_id' => 2],
				['name' => 'Save Resources', 'key' => 'save_document', 'lang_key' => 'role_save_doc', 'disabled' => 0, 'group_id' => 2],
				['name' => 'Publish Resources', 'key' => 'publish_document', 'lang_key' => 'role_publish_doc', 'disabled' => 0, 'group_id' => 2],
				['name' => 'Delete Resources', 'key' => 'delete_document', 'lang_key' => 'role_delete_doc', 'disabled' => 0, 'group_id' => 2],
				['name' => 'Permanently purge deleted Resources', 'key' => 'empty_trash', 'lang_key' => 'role_empty_trash', 'disabled' => 0, 'group_id' => 2],
				['name' => 'Empty the sites cache', 'key' => 'empty_cache', 'lang_key' => 'role_cache_refresh', 'disabled' => 0, 'group_id' => 2],
				['name' => 'View Unpublished Resources', 'key' => 'view_unpublished', 'lang_key' => 'role_view_unpublished', 'disabled' => 0, 'group_id' => 2],
				['name' => 'Use the file manager (full root access)', 'key' => 'file_manager', 'lang_key' => 'role_file_manager', 'disabled' => 0, 'group_id' => 3],
				['name' => 'Manage assets/files', 'key' => 'assets_files', 'lang_key' => 'role_assets_files', 'disabled' => 0, 'group_id' => 3],
				['name' => 'Manage assets/images', 'key' => 'assets_images', 'lang_key' => 'role_assets_images', 'disabled' => 0, 'group_id' => 3],
				['name' => 'Use the Category Manager', 'key' => 'category_manager', 'lang_key' => 'role_category_manager', 'disabled' => 0, 'group_id' => 4],
				['name' => 'Create new Module', 'key' => 'new_module', 'lang_key' => 'role_new_module', 'disabled' => 0, 'group_id' => 5],
				['name' => 'Edit Module', 'key' => 'edit_module', 'lang_key' => 'role_edit_module', 'disabled' => 0, 'group_id' => 5],
				['name' => 'Save Module', 'key' => 'save_module', 'lang_key' => 'role_save_module', 'disabled' => 0, 'group_id' => 5],
				['name' => 'Delete Module', 'key' => 'delete_module', 'lang_key' => 'role_delete_module', 'disabled' => 0, 'group_id' => 5],
				['name' => 'Run Module', 'key' => 'exec_module', 'lang_key' => 'role_run_module', 'disabled' => 0, 'group_id' => 5],
				['name' => 'List Module', 'key' => 'list_module', 'lang_key' => 'role_list_module', 'disabled' => 0, 'group_id' => 5],
				['name' => 'Create new site Templates', 'key' => 'new_template', 'lang_key' => 'role_create_template', 'disabled' => 0, 'group_id' => 6],
				['name' => 'Edit site Templates', 'key' => 'edit_template', 'lang_key' => 'role_edit_template', 'disabled' => 0, 'group_id' => 6],
				['name' => 'Save Templates', 'key' => 'save_template', 'lang_key' => 'role_save_template', 'disabled' => 0, 'group_id' => 6],
				['name' => 'Delete Templates', 'key' => 'delete_template', 'lang_key' => 'role_delete_template', 'disabled' => 0, 'group_id' => 6],
				['name' => 'Create new Snippets', 'key' => 'new_snippet', 'lang_key' => 'role_create_snippet', 'disabled' => 0, 'group_id' => 7],
				['name' => 'Edit Snippets', 'key' => 'edit_snippet', 'lang_key' => 'role_edit_snippet', 'disabled' => 0, 'group_id' => 7],
				['name' => 'Save Snippets', 'key' => 'save_snippet', 'lang_key' => 'role_save_snippet', 'disabled' => 0, 'group_id' => 7],
				['name' => 'Delete Snippets', 'key' => 'delete_snippet', 'lang_key' => 'role_delete_snippet', 'disabled' => 0, 'group_id' => 7],
				['name' => 'Create new Chunks', 'key' => 'new_chunk', 'lang_key' => 'role_create_chunk', 'disabled' => 0, 'group_id' => 8],
				['name' => 'Edit Chunks', 'key' => 'edit_chunk', 'lang_key' => 'role_edit_chunk', 'disabled' => 0, 'group_id' => 8],
				['name' => 'Save Chunks', 'key' => 'save_chunk', 'lang_key' => 'role_save_chunk', 'disabled' => 0, 'group_id' => 8],
				['name' => 'Delete Chunks', 'key' => 'delete_chunk', 'lang_key' => 'role_delete_chunk', 'disabled' => 0, 'group_id' => 8],
				['name' => 'Create new Plugins', 'key' => 'new_plugin', 'lang_key' => 'role_create_plugin', 'disabled' => 0, 'group_id' => 9],
				['name' => 'Edit Plugins', 'key' => 'edit_plugin', 'lang_key' => 'role_edit_plugin', 'disabled' => 0, 'group_id' => 9],
				['name' => 'Save Plugins', 'key' => 'save_plugin', 'lang_key' => 'role_save_plugin', 'disabled' => 0, 'group_id' => 9],
				['name' => 'Delete Plugins', 'key' => 'delete_plugin', 'lang_key' => 'role_delete_plugin', 'disabled' => 0, 'group_id' => 9],
				['name' => 'Create new users', 'key' => 'new_user', 'lang_key' => 'role_new_user', 'disabled' => 0, 'group_id' => 10],
				['name' => 'Edit users', 'key' => 'edit_user', 'lang_key' => 'role_edit_user', 'disabled' => 0, 'group_id' => 10],
				['name' => 'Save users', 'key' => 'save_user', 'lang_key' => 'role_save_user', 'disabled' => 0, 'group_id' => 10],
				['name' => 'Delete users', 'key' => 'delete_user', 'lang_key' => 'role_delete_user', 'disabled' => 0, 'group_id' => 10],
				['name' => 'Access permissions', 'key' => 'access_permissions', 'lang_key' => 'role_access_persmissions', 'disabled' => 0, 'group_id' => 11],
				['name' => 'Web access permissions', 'key' => 'web_access_permissions', 'lang_key' => 'role_web_access_persmissions', 'disabled' => 0, 'group_id' => 11],
				['name' => 'Create new roles', 'key' => 'new_role', 'lang_key' => 'role_new_role', 'disabled' => 0, 'group_id' => 12],
				['name' => 'Edit roles', 'key' => 'edit_role', 'lang_key' => 'role_edit_role', 'disabled' => 0, 'group_id' => 12],
				['name' => 'Save roles', 'key' => 'save_role', 'lang_key' => 'role_save_role', 'disabled' => 0, 'group_id' => 12],
				['name' => 'Delete roles', 'key' => 'delete_role', 'lang_key' => 'role_delete_role', 'disabled' => 0, 'group_id' => 12],
				['name' => 'View event log', 'key' => 'view_eventlog', 'lang_key' => 'role_view_eventlog', 'disabled' => 0, 'group_id' => 13],
				['name' => 'Delete event log', 'key' => 'delete_eventlog', 'lang_key' => 'role_delete_eventlog', 'disabled' => 0, 'group_id' => 13],
				['name' => 'View system logs', 'key' => 'logs', 'lang_key' => 'role_view_logs', 'disabled' => 0, 'group_id' => 14],
				['name' => 'Change site settings', 'key' => 'settings', 'lang_key' => 'role_edit_settings', 'disabled' => 0, 'group_id' => 14],
				['name' => 'Use the Backup Manager', 'key' => 'bk_manager', 'lang_key' => 'role_bk_manager', 'disabled' => 0, 'group_id' => 14],
				['name' => 'Remove Locks', 'key' => 'remove_locks', 'lang_key' => 'role_remove_locks', 'disabled' => 0, 'group_id' => 14],
				['name' => 'Display Locks', 'key' => 'display_locks', 'lang_key' => 'role_display_locks', 'disabled' => 0, 'group_id' => 14]
			];
			foreach ($insertArray as $record) {
				$insert = $modx->db->insert($record, $modx->db->config['table_prefix']."permissions");
			}
			
			$output .=  time()." Created permissions!<br />";
		}
		// END PERMISSIONS //

		// ROLE PERMISSIONS //
		$rs = $modx->db->query("SHOW TABLES LIKE '".$modx->db->config['table_prefix']."role_permissions';");
		$count = $modx->db->getRecordCount($rs);
		
		if ( $count == 0 ) {

			$sql = "CREATE TABLE `".$modx->db->config['table_prefix']."role_permissions` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `permission` varchar(255) CHARACTER SET latin1 NOT NULL,
				  `role_id` int(11) NOT NULL,
				  `created_at` timestamp NULL DEFAULT NULL,
				  `updated_at` timestamp NULL DEFAULT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4

				;";
			$modx->db->query($sql);
			
			$fields = ['migration' => '2018_06_29_182342_create_role_permissions_table', 'batch' => 1];
			$modx->db->insert($fields,  $modx->db->config['table_prefix']."migrations_install" );
			
			$sql = " SELECT * FROM `". $modx->db->config['table_prefix']."user_roles`;";
			$rs = $modx->db->query($sql);
			
			while ( $row = $modx->db->getRow($rs) ) {
				$result[] = $row;
			}
			
			foreach ($result as $role) {
				$id = $role['id'];
				unset($role['id']);
				unset($role['name']);
				unset($role['description']);
				foreach ($role as $key => $value) {
					if ($value == 1)
						$modx->db->insert( ['permission' => $key, 'role_id' => $id], $modx->db->config['table_prefix']."role_permissions" );
				}

				if ($role['exec_module'] == 1) {
					$modx->db->insert( ['permission' => 'list_module', 'role_id' => $id], $modx->db->config['table_prefix']."role_permissions" );
				}
				if ($role['new_chunk'] == 1) {
					$modx->db->insert( ['permission' => 'access_permissions', 'role_id' => $id], $modx->db->config['table_prefix']."role_permissions" );
				}
			}
			$output .=  time()." Created role_permissions!<br />";
		}
		
		if ( empty($output) ) $output = 'All Tables already Installed.<br />';
		
		return $output;
		// END ROLE PERMISSIONS //
	}

	static public function systemEvents () {
		$modx = EvolutionCMS();
	
		$output = '';
		
		// SYSTEM EVENTS //
		$sql = "SELECT * FROM ".$modx->db->config['table_prefix']."system_eventnames WHERE name='OnBeforeUserSave';";
		$rs = $modx->db->query($sql);
		$count = $modx->db->getRecordCount($rs);

		if ($count == 0) {
			$fields = array(
					'name' => 'OnBeforeUserSave',
					'service' => 1,
					'groupname' => 'Users'
				);
			$modx->db->insert( $fields, $modx->db->config['table_prefix']."system_eventnames" );
			$output .= "Set OnBeforeUserSave<br />";
		}


		$sql = "SELECT * FROM ".$modx->db->config['table_prefix']."system_eventnames WHERE name='OnUserSave';";
		$rs = $modx->db->query($sql);
		$count = $modx->db->getRecordCount($rs);

		if ($count == 0) {
			$fields = array(
					'name' => 'OnUserSave',
					'service' => 1,
					'groupname' => 'Users'
				);
			$modx->db->insert( $fields, $modx->db->config['table_prefix']."system_eventnames" );
			$output .= "Set OnUserSave<br />";
		}


		$sql = "SELECT * FROM ".$modx->db->config['table_prefix']."system_eventnames WHERE name='OnUserDelete';";
		$rs = $modx->db->query($sql);
		$count = $modx->db->getRecordCount($rs);

		if ($count == 0) {
			$fields = array(
					'name' => 'OnUserDelete',
					'service' => 1,
					'groupname' => 'Users'
				);
			$modx->db->insert( $fields, $modx->db->config['table_prefix']."system_eventnames" );
			$output .= "Set OnUserDelete<br />";
		}


		$sql = "SELECT * FROM ".$modx->db->config['table_prefix']."system_eventnames WHERE name='OnBeforeUserDelete';";
		$rs = $modx->db->query($sql);
		$count = $modx->db->getRecordCount($rs);

		if ($count == 0) {
			$fields = array(
					'name' => 'OnBeforeUserDelete',
					'service' => 1,
					'groupname' => 'Users'
				);
			$modx->db->insert( $fields, $modx->db->config['table_prefix']."system_eventnames" );
			$output .= "Set OnBeforeUserDelete<br />";
		}
		
		if ( empty($output) ) $output = 'No System Events Installed or already Installed.<br />';
		
		return $output;
	}
	
	static public function migrateUsers () {
		$modx = EvolutionCMS();
		
		$output = '';
		$tempWebGroupAccess = 'tempwebgroup_access';
		$base_dir = $modx->config['base_path'];
		
		/*
		
		// We are going to create membergroup_names to match the webuser_names
		$output .=  "Moving webgroup_names to membergroup_names";
		$output .=  "<hr />";
		$rsWebGroups = $modx->db->select("name", $modx->getFullTableName('webgroup_names'), "", "id DESC" );
		while ( $row = $modx->db->getRow($rsWebGroups) ) {
			$output .=  "Checking for duplicate group: ".$row['name'];
			
			$rsGroupDuplicate = $modx->db->select( "name", $modx->getFullTableName('membergroup_names'), "name='".$row['name']."'", "id ASC");
			if ( $modx->db->getRecordCount($rsGroupDuplicate) > 0 ) {
				$output .=  " <strong>duplicate found!</strong><br />";
			} else {
				$modx->db->insert(array( "name" => $row['name']), $modx->getFullTableName('membergroup_names') );
			}
			$output .=  "<br />";
		}
		
		$output .=  "Moving the old web_groups records to the new member_groups table";
		$output .=  "<hr />";
		
		
		$rs = $modx->db->query('SHOW TABLES LIKE "%'.$tempWebGroupAccess.'%"');
		$count = $modx->db->getRecordCount($rs);

		// Content Database
		if ( $count == 0 ) {
			// We should move webgroup_access to a temp table so we can import it later after the migration.
			$sql = 'CREATE TABLE '.$modx->getFullTableName($tempWebGroupAccess).' AS 
					SELECT 
						t3.id as webgroup,
						documentgroup,
						"1"
					FROM '.$modx->getFullTableName('webgroup_access').' t1
					INNER JOIN '.$modx->getFullTableName('webgroup_names').' t2 ON t1.webgroup = t2.id
					INNER JOIN '.$modx->getFullTableName('membergroup_names').' t3 ON t3.name = t2.name;';
			
			$rs = $modx->db->query($sql);
			$output .=  "Created temporary webgroup_access table for migration after the installation of v3";
		}
		*/
		
		// MIGRATING MANAGERS TO USERS //

		// Get the manager users
		$rsUsers = $modx->db->select( "*", $modx->getFullTableName('manager_users') );
		file_put_contents($base_dir.'/assets/cache/users.txt', "old_user_id||new_user_id\n", FILE_APPEND);

		while ( $user = $modx->db->getRow($rsUsers) ) {
			$userAttributes = array();
			$userSettings = array();
			$userMemberGroup = array();
			
			$output .=  $user['id']."<br />";
			$oldId = $user['id'];
			
			// MAnager attributes
			$rsUser = $modx->db->select( "*", $modx->getFullTableName('user_attributes'), "id=".$oldId );
			$userAttributes = $modx->db->getRow($rsUser);
			unset($userAttributes['id']); // We don't need this but we do need to create it for the newly inserted user record
			
			// Manager Settings
			$rsUserSettings = $modx->db->select( "*", $modx->getFullTableName('user_settings'), "user=".$oldId );
			while ( $row = $modx->db->getRow($rsUserSettings) ) {
				unset($row['user']); // remove the user id
				$userSettings[] = $row;
			}
			
			//print_r($userSettings);
			
			$output .=  "<hr />";
			
			// Member Groups
			$rsMemberGroup = $modx->db->select( "*", $modx->getFullTableName('member_groups'), "member=".$oldId );
			while ( $row = $modx->db->getRow($rsMemberGroup) ) {
				$userMemberGroup[] = $row;
			}
			
			$output .=  "Creating User!<br />";
			$newUser = array(
					"password" => $user['password'],
					"username" => $user['username']
				);
			$newId = $modx->db->insert($newUser, $modx->getFullTableName('web_users'));
			
			$modx->db->query("UPDATE {$modx->getFullTableName('site_content')} SET `createdby`={$newId} WHERE `createdby`={$oldId}");
			$modx->db->query("UPDATE {$modx->getFullTableName('site_content')} SET `editedby`={$newId} WHERE `editedby`={$oldId}");
			$modx->db->query("UPDATE {$modx->getFullTableName('site_content')} SET `deletedby`={$newId} WHERE `deletedby`={$oldId}");
			
			file_put_contents($base_dir.'/assets/cache/users.txt', $oldId.'||'.$newId."\n", FILE_APPEND);
			
			$output .=  "Migrating User Attributes<br />";
			$output .=  "Set Attributes to New ID<br/>";
			$userAttributes['internalKey'] = $newId;
			
			$modx->db->insert($userAttributes, $modx->getFullTableName('web_user_attributes') );
			
			$output .=  "Migrating User Settings<br />";
			$output .=  "Set Settings to New ID<br/>";
			
			$i=0;
			while ($i < count($userSettings) ) {
				$userSettings[$i]['webuser'] = $newId;
				$modx->db->insert($userSettings[$i], $modx->getFullTableName('web_user_settings') );
				$i++;
			}
			
			$output .=  "Migrating Member Groups<br />";
			$output .=  "This will update the old admin id's with the new user id for any connected groups";
			$output .=  "<hr />";
			$output .=  "Normally manager users are not a part of web user groups - There should be nothing to do here!";
			$output .=  "<hr />";
			$i=0;
			while ($i < count($userMemberGroup) ) {
				$userMemberGroup[$i]['member'] = $newId;
				$modx->db->insert($userMemberGroup[$i], $modx->getFullTableName('member_groups') );		
				$i++;
			}
			
			$output .=  "Moving webgroup_names to membergroup_names";
			$output .=  "<hr />";
			$rsWebGroups = $modx->db->select("name", $modx->getFullTableName('webgroup_names'), "", "id DESC" );
			while ( $row = $modx->db->getRow($rsWebGroups) ) {
				$output .=  "Checking for duplicate group: ".$row['name']."<br />";
				
				$rsGroupDuplicate = $modx->db->select( "name", $modx->getFullTableName('membergroup_names'), "name='".$row['name']."'", "id ASC");
				if ( $modx->db->getRecordCount($rsGroupDuplicate) > 0 ) {
					$output .=  "duplicate found!<br />";
				} else {
					$modx->db->insert(array( "name" => $row['name']), $modx->getFullTableName('membergroup_names') );
				}
			}
			
			$output .=  "deleting the old manager user<br />";
			$modx->db->delete($modx->getFullTableName('user_attributes'), "internalKey=".$oldId);
			$modx->db->delete($modx->getFullTableName('user_settings'), "user=".$oldId);
			$modx->db->delete($modx->getFullTableName('member_groups'), "member=".$oldId);
		}
		
			$output .=  "Moving the old web_groups records to the new member_groups table";
			$output .=  "<hr />";
			
			$sql = "INSERT INTO ".$modx->getFullTableName('member_groups')." (user_group, member)
					SELECT 
						t3.id as  user_group,
						t1.webuser as member
					FROM ".$modx->getFullTableName('web_groups')." t1
					INNER JOIN ".$modx->getFullTableName('webgroup_names')." t2 ON t1.webgroup = t2.id
					INNER JOIN ".$modx->getFullTableName('membergroup_names')." t3 ON t3.name = t2.name;";
			$rs = $modx->db->query($sql);
			
			$output .=  "Moved old web_groups records to the new member_groups table";
			$output .=  "<hr />";
			
			$output .=  "Moving the old webgroup_access records to the new membergroup_access table";
			$output .=  "<hr />";
			
			$sql = "INSERT INTO ".$modx->getFullTableName('membergroup_access')." (membergroup, documentgroup)
					SELECT 
						t3.id as  membergroup,
						t1.documentgroup as documentgroup
					FROM ".$modx->getFullTableName('webgroup_access')." t1
					INNER JOIN ".$modx->getFullTableName('webgroup_names')." t2 ON t1.webgroup = t2.id
					INNER JOIN ".$modx->getFullTableName('membergroup_names')." t3 ON t3.name = t2.name;";
			$rs = $modx->db->query($sql);
			
			$output .=  "Moved old webgroup_access records to the new membergroup_access table";
			$output .=  "<hr />";
		
		return $output;
	}
	
	static public function installv3 () {
		$modx = EvolutionCMS();
		
		$output = '';
		
		// Install new system files //
		$base_dir = $modx->config['base_path'];
		
		$temp_dir = $base_dir . '/_temp' . md5(time());
		
		$config_2_dir = $base_dir . '/core/config/database/connections/default.php';
		
		$database_engine = 'MyISAM';
		$database_engine = 'InnoDB';

		EvoInstaller::checkVersion($base_dir);
		$config = EvoInstaller::checkConfig($base_dir, $config_2_dir, $database_engine, $modx->db->config);

		//run unzip and install
		EvoInstaller::downloadFile('https://github.com/evocms-community/evolution/archive/refs/heads/3.x.zip', $base_dir.'evo.zip');

		$zip = new ZipArchive;
		$res = $zip->open($base_dir . '/evo.zip');
		$zip->extractTo($temp_dir);
		$zip->close();
		unlink($base_dir . '/evo.zip');

		if ($handle = opendir($temp_dir)) {
			while (false !== ($name = readdir($handle))) {
				if ($name != '.' && $name != '..') $dir = $name;
			}
			closedir($handle);
		}

		EvoInstaller::rmdirs($base_dir . '/manager');
		EvoInstaller::rmdirs($base_dir . '/vendor');
		if (file_exists($base_dir . '/assets/cache/siteManager.php')) {
			unlink($base_dir . '/assets/cache/siteManager.php');
		}
		EvoInstaller::moveFiles($temp_dir . '/' . $dir, $base_dir . '/');
		if ($config != '') {
			file_put_contents($config_2_dir, $config);
		}
		EvoInstaller::rmdirs($temp_dir);
		if (file_exists($base_dir . '/assets/cache/siteCache.idx.php')){

			unlink($base_dir . '/assets/cache/siteCache.idx.php');
		}
		if (file_exists($base_dir . '/core/storage/bootstrap/siteCache.idx.php')) {
			unlink($base_dir . '/core/storage/bootstrap/siteCache.idx.php');
		}

		file_put_contents($base_dir . '/core/.install', time());
		// Do not delete the module file.
		//unlink(__FILE__);

		$output .=  "<hr />Please ensure you run the install program as normal. <a target='_new' href='".$modx->getConfig("site_url")."install'>Complete installation</a><hr />";
		// END INSTALL NEW SYSTEM FILES //
		
		return $output;
	}
}

class EvoInstaller
{
    static public function downloadFile($url, $path) {
        $newfname = $path;
        $rs = file_get_contents($url);
        if ($rs) $rs = file_put_contents($newfname, $rs);
        return $rs;
    }

    static public function rmdirs($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object) && !is_link($dir . "/" . $object))
                        self::rmdirs($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            rmdir($dir);
        }
    }

    static public function moveFiles($src, $dest) {
        $path = realpath($src);
        $dest = realpath($dest);
        $objects = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        foreach ($objects as $name => $object) {
            $startsAt = substr(dirname($name), strlen($path));
            self::mmkDir($dest . $startsAt);
            if ($object->isDir()) {
                self::mmkDir($dest . substr($name, strlen($path)));
            }

            if (is_writable($dest . $startsAt) && $object->isFile()) {
                rename((string)$name, $dest . $startsAt . '/' . basename($name));
            }
        }
    }

    static public function mmkDir($folder, $perm = 0777) {
        if (!is_dir($folder)) {
            mkdir($folder, $perm);
        }
    }

    static public function checkVersion($base_dir) {
		$output = '';
        if (file_exists($base_dir . '/core/factory/version.php')) {
            $data = include $base_dir . '/core/factory/version.php';
            if (version_compare($data['version'], '2.0.4', '<')) {
                $output .=  'Please update to version 2.0.4 before start this script';
				return $output;
                exit();
            } else {
                return;
            }

        }
        if (file_exists($base_dir . '/manager/includes/version.inc.php')) {
            include $base_dir . '/manager/includes/version.inc.php';
            if (version_compare($modx_version, '1.4.12', '<')) {
                $output .=  'Please update to version 1.4.12 before start this script';
				return $output;
                exit();
            }
        }
    }

    static public function checkConfig($base_dir, $config_2_dir, $database_engine, $parameters) {
		$output = '';
	
		if ($parameters['host'] == '127.0.0.1') $parameters['host'] = 'localhost';
        if (file_exists($config_2_dir)) {
            return '';
        }
        $config_file_1_4 = $base_dir . '/manager/includes/config.inc.php';
		
        if (!file_exists($config_file_1_4)) {
            $output .=  'config file not exists';
            exit();
        }
        
		//include $config_file_1_4;
        $output .=  $parameters['charset'];
		switch ( $parameters['charset'] ) {
			case "utf8":
				$database_connection_charset_ = 'utf8_general_ci';
				break;
			case "utf8mb4":
				$database_connection_charset_ = 'utf8mb4_general_ci';
				break;
			case "cp1251":
				$database_connection_charset_ = 'cp1251_general_ci';
				break;
			default:
				$database_connection_charset_ = 'latin1_swedish_ci';
				break;
		}

        $arr_config['[+database_type+]'] = 'mysql';
        $arr_config['[+database_server+]'] = $parameters['host'];
        $arr_config['[+database_port+]'] = 3306;
        $arr_config['[+dbase+]'] = str_replace('`', '', $parameters['dbase']);
        $arr_config['[+user_name+]'] = $parameters['user'];
        $arr_config['[+password+]'] = $parameters['pass'];
        $arr_config['[+connection_charset+]'] = $parameters['charset'];
        $arr_config['[+connection_collation+]'] = $database_connection_charset_;
        $arr_config['[+table_prefix+]'] = $parameters['table_prefix'];
        $arr_config['[+connection_method+]'] = $parameters['connection_method'];
        $arr_config['[+database_engine+]'] = $database_engine;
		
        $str = "<?php
return [
    'driver' => env('DB_TYPE', '[+database_type+]'), 
    'host' => env('DB_HOST', '[+database_server+]'), 
    'port' => env('DB_PORT', '[+database_port+]'), 
    'database' => env('DB_DATABASE', '[+dbase+]'), 
    'username' => env('DB_USERNAME', '[+user_name+]'), 
    'password' => env('DB_PASSWORD', '[+password+]'), 
    'unix_socket' => env('DB_SOCKET', ''),
    'charset' => env('DB_CHARSET', '[+connection_charset+]'), 
    'collation' => env('DB_COLLATION', '[+connection_collation+]'),
    'prefix' => env('DB_PREFIX', '[+table_prefix+]'),
    'method' => env('DB_METHOD', 'SET CHARACTER SET'), 
    'strict' => env('DB_STRICT', false),
    'engine' => env('DB_ENGINE', '[+database_engine+]'),
    'options' => [
        PDO::ATTR_STRINGIFY_FETCHES => true,
    ]
];";
        $str = str_replace(array_keys($arr_config), array_values($arr_config), $str);
		
        return $str;
    }
}
