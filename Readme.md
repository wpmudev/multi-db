# Multi DB

**INACTIVE NOTICE: This plugin is unsupported by WPMUDEV, we've published it here for those technical types who might want to fork and maintain it for their needs.**

The standard WordPress Multisite installation requires only one database – which is great for hobbyists or people just looking to host a few dozen or few hundred sites.

When you get past a few hundred sites, a single database can get cramped.

Multi-DB works to make better use of your server by creating either 16, 256 or 4096 database tables and spreading new blogs evenly across your system.


If you’re in need of a tool that spreads sites on your network across multiple database tables, Multi-DB has been tested and used on thousands of sites since 2008.

It is a fantastic foundation for anyone looking to spread their content across more than one database.

## Usage Docs

**Important: Please note that this is not your normal “drop-the-files-here” plugin, and it is not to be uploaded to wp-content/plugins**

This is sysadmin-level stuff. But don’t be scared off, with the right mindset (and server configuration) you can do it!

#### First, is your server setup right for this?

 * Do you have root access to your server, access to phpMyAdmin, and can you run SQL scripts on your database?
 * If you are big enough to need Multi-DB, you really should be using a VPS or dedicated server that gives you root access.
 * If your host or server is using a control panel like cPanel, or they run DB servers externally (ie – shared hosting, grid hosting, etc), you may not have permissions to create DBs via an SQL script.
 * So first see if you can login as root and run stuff via command line. If not, you may need to create the DBs manually one at a time through the control panel (cPanel).
Your server meets the requirements and you’re ready to roll? Then let’s do this!

## Preparation is Key

Multi-DB is one of those plugins that becomes an absolute necessity for any Multisite network that is seeing or expecting substantial numbers of blogs/sites.

It is powerful in what it does (spreading the WordPress tables across several databases), but as with anything else, getting it set up correctly with adequate preparation for installation is essential to success.

The key to success with this plugin is to have the settings edited and triple-checked BEFORE uploading to your site.

If you’ve not attempted this before, we recommend reading through this entire process first. Then read it again and follow along. Finally, go back through and make sure each setting is correct. Then you should be ready for an install without incident!

*STOP! Before going any further, please make a full backup of your multisite so, just in case things go kaflooey, you can restore it!*

## Creating Your Databases

Decide how many databases you want (16, 256, 4096)
So, how do you know that this plugin is necessary for your install? Well, there are several factors to consider beyond the scope of this walkthrough, but here’s a basic guideline:

 * 1 – 5,000 blogs/sites: you should be fine with your WordPress default database
 * 5,000 – 50,000 blogs/sites: go with 16 databases
 * 50,000 – 100,000 blogs/sites: use 256 databases
 * 100,000+ blogs/sites: use 4096 databases

There’s no performance hit for using 256 databases over 16. But if you’re expecting massive growth, planning ahead at this point will save you additional work down the road.

In fact, unless you already know you won’t be growing past 50,000 blogs/sites it’s best just to do the 256 just in case. Using 4096 DBs is usually overkill unless you plan on being the next wordpress.com or edublogs.org!

As stated earlier, there are several factors to consider and this is meant to be a general guide. It’s really a decision specific to your site needs.

### Decide if you need VIP databases
This plugin has a cool feature that allows for VIP databases. It enables you to place specific blog(s) in specific database(s).

 * Unless you have a blog/site that gets a ton of traffic and you want to put it on another physical server for performance reasons, then it’s not really worth it to bother with this feature.
 * The vast majority of installs do not need to use VIP blogs, so skip it unless you are sure you need to use this feature.
 * Each VIP blog/site will have its own database, and they will be identified as vip1, vip2, etc.
 * If you do decide you need this, you’ll be using the add_vip_blog() function in db-config.php to move specific blogs to these databases (more on that below).

## Create the mySQL command

While you can name your databases anything you like, we know from experience that ordering them as we have in this walkthrough will make management easier down the road, and it also lets you more easily use the included db-config.php file.

We’ll get to that file in the next step below, but first we need to get the proper SQL command set up. We’ve provided an easy tool for that, you can check it under /db-tools/ within this repository.

**IMPORTANT: Once you upload the db-tools directory to your site, any logged in user will be able to access it.**

Be sure you’re on the correct tool for database creation by clicking the DB SQL link at the top of the page.

![M](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-db-tools.png)

 * In the DB Name field, type in your database name (it should be the same name as your current WordPress DB) followed by an underscore ( _ ). The underscore is very important as this creates the prefix for your new databases. Without that underscore, nothing will work!
 * Next, choose the number of databases you need from the dropdown. Then click the Submit button.

In the textarea below, you’ll now see all the instructions mySQL needs to create your new DBs.

![M](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-dbs-created.png)

Well, almost all; there is one other line you need to add manually to create the required global database.

 * Copy the final line generated by the database tool, and paste it directly beneath all the others in the textarea of the DB creation tool.
 * Then change dbname_f to dbname_global in that new line. That’s it.

Your final output for the required global database will look something like this:

`CREATE DATABASE 'dbname_global' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;`

Did you also decide to create optional VIP databases for some of your blogs/sites as mentioned above? If so…

 * Add another line in the textarea for each one you need.
 * Change dbname_f to dbname_vip1 for the first one.
 * If you are creating more than one, change dbname_f to dbname_vip2 for the second one, dbname_vip3 for the third one, and so on.

The final output for each of your VIP databases would look something like this:

`CREATE DATABASE 'dbname_vip1' DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;`

Be sure you’ve added these extra line(s) directly beneath those created by the DB SQL tool.

## Create the Databases
Now, you need to create the databases, either via command line (hardcore) or through phpMyAdmin (much easier).

Log into your server and, if you’re using phpMyAdmin, be sure you’re in the root and click the SQL tab. Then paste in the SQL command you just generated (the contents of the textarea from the DB SQL tool), and click the “Go” button.

Note that the screenshot below does not include any lines for VIP databases. However, if you are creating some, they would be there.

![M](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-phpmyadmin-created.png)

Now when you click the “Databases” tab in a tool like **phpMyAdmin**, you should see loads of new databases where there used to be only one or two.

![M](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-phpmyadmin-create.png)

Note that even though your new databases may appear instantly in phpMyAdmin, it can sometimes take several minutes – even hours – for them to appear in cPanel.

In some instances, you may even need to wait until the next day. This is beyond our, and your, control. Patience, Grasshopper. :)

## Assigning Users & Passwords

A username and password must be associated with each database.

 * This could be the same as your username and password for the original WordPress database. Or you could create new users for your new databases.
 * It’s up to you, just make sure that there IS a username and password associated with each one and note what they are. You’ll need this information for the next part of the installation.

You can create and assign usernames & passwords either directly in phpMyAdmin, or use the **MySQL Databases** section in your cPanel.

## Creating Users & Passwords in phpMyAdmin
If you have CREATE USER privileges in phpMyAdmin, you can use any of the following commands in the SQL tab (the same place where you just added the command to create your new databases).

To assign all privileges on all databases to an existing user (probably you), you can use this command:

`GRANT ALL PRIVILEGES ON * . * TO 'username'@'localhost';
FLUSH PRIVILEGES;`

Or, if you want to create a new username/password combination & assign all privileges on all databases to that user, use this command:

`CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON * . * TO 'username'@'localhost';
FLUSH PRIVILEGES;`

The asterisks in the above commands represent, respectively, all databases & all tables.

If you are using VIP databases, and want to create and grant privileges to different users in each of those, you’d first create the user(s) and their password(s), then specify the username for each database using a command like this (note the database specified instead of the first asterisk):

``` 
CREATE USER 'user1'@'localhost' IDENTIFIED BY 'pass1';
CREATE USER 'user2'@'localhost' IDENTIFIED BY 'pass2';
GRANT ALL PRIVILEGES ON dbname_vip1 . * TO 'user1'@'localhost';
GRANT ALL PRIVILEGES ON dbname_vip2 . * TO 'user2'@'localhost';
GRANT ALL PRIVILEGES ON dbname_global . * TO 'username'@'localhost';
GRANT ALL PRIVILEGES ON dbname_0 . * TO 'username'@'localhost';
GRANT ALL PRIVILEGES ON dbname_1 . * TO 'username'@'localhost';
GRANT ALL PRIVILEGES ON dbname_2 . * TO 'username'@'localhost';
GRANT ALL PRIVILEGES ON dbname_3 . * TO 'username'@'localhost';
GRANT ALL PRIVILEGES ON dbname_4 . * TO 'username'@'localhost';
GRANT ALL PRIVILEGES ON dbname_5 . * TO 'username'@'localhost';
...
FLUSH PRIVILEGES;
```

Be sure to include an additional line for each database as indicated by the ellipsis (…).

In each of the above cases, replace the words `user1`, `user2`, `pass1`, `pass2`, username & password in the code with the actual usernames & passwords. :)

Also remember to change `dbname_0`, `dbname_1`, etc, to the actual names of your databases.

[For more on this, see this handy tutorial at DigitalOcean](https://www.digitalocean.com/community/tutorials/how-to-create-a-new-user-and-grant-permissions-in-mysql).

##Creating Users & Passwords in cPanel
If you do not have CREATE USER privileges in phpMyAdmin, or just don’t want to mess around in there, you can add the username & password to each new database in your cPanel.

To do that, scroll down to the Databases section on the main page of your cPanel, and click the **MySQL Databases** link.

![](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-cpanel-phpmyadmin.png)

On the next screen, fill in the fields in the **Add New User** section to create any new user(s) that you may want.

Then, assign existing user(s) to the appropriate database(s) in the **Add User To Database** section.

![](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-cpanel-add-users.png)

When you click the **Add** button to add a user to a database, you’ll get a screen where you can assign the privileges for that user & database.

![](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-cpanel-user-privileges.png)

Simply check the **All Privileges** box and click **Make Changes**.

You’ll need to add a user to each database and grant permissions for each one in the manner detailed above.

So, if you have added 16 databases, you’ll do this 16 times; for 256 databases, you’ll do it 256 times; 4096 databases, well, you get the idea. :)


## Configuring the Plugin Files

Your databases are created and you’ve assigned usernames & passwords to each one?

Excellent! Now it’s time to start configuring the plugin to handle the heavy lifting. We’ve got several areas to configure in 2 different files.

So if you haven’t already downloaded your copy of Multi-DB by clicking the big button at the top of this page, please do that now.

### Configuring `db-config.php`
Unzip the file you just downloaded, and open `db-config.php` in a text editor like Sublime Text

The first thing to do is enter the number of new databases you just created, and the IP address of your multisite.

![](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-db-config-1.png)

 * Line 10: Change the number next to DB_SCALING to however many new databases you created (16, 256, or 4096)
 * Line 16: On this line, enter ONLY the first 3 quadrants of your multisite’s IP address, with a dot at the end.For example, if your IP is `111.222.333.444` you would enter `111.222.333`. including the dot. It would look like this: `add_dc_ip('111.222.333.', 'dc1');`

Next, we want to add in the new global database name.

![](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-db-config-2.png)

 * Scroll down to line 25, and add a new blank line there. On that line, enter the the command for your new global database.Remember to change `dbname_global` to the actual name of the global database you created. It would look like this: `add_global_table('dbname_global');`

The other global table lines in there are required by the plugins specified.

 * If you’re not using any of those plugins, you can safely leave those lines there. It’s like having an empty closet: you’re not using it, but it’s nice to know it’s there if you do need it.

The next thing we want to configure in this file is the *DB Servers* section.

To do that, we’re going to use another of the online tools we have provided: 
http://yourdomain.com/db-tools/db_servers.php

Click on that link now, and be sure you’re on the correct tool by clicking the DB Servers link at the top of the page.

![](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-db-tools-2.png)

 * In the **DB Name** field, type in your database name just like you did with the previous tool, followed by the underscore ( _ ). Again, the underscore is very important here; without it, stuff won’t work.
 * Enter your username in the **DB User** field, and your password in the **DB Pass** field.
 * In the **DB Local Host** field, enter the full IP of your multisite. Ex: `111.222.333.444`
 * The DB Remote Host field is only required if your databases are hosted on a different IP from your WordPress install (a remote server). If they are, enter that IP here.If, as is usually the case, your databases are at the same IP as your WordPress site, you can ignore the need for a remote server entirely, and leave the field blank.
 * Finally, select the number of databases you already created from the dropdown. Then click the **Submit** button.

In the textarea below, you’ll now see all the instructions you need to paste in the *DB Servers* section of `db-config.php`

Your output should look similar to the following:

![Multi-DB Servers Created](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-db-tools-3.png)

The actual values will be the ones you entered. If you did not enter anything for the remote host, that value will simply be empty.

Just as we did when creating the new databases, we want to add a special line here too for our global database.

 * Copy one of the lines generated, and paste it directly **above** all the others in the textarea of the DB Servers tool.
 * Change the number at the beginning of that new line to`global`.
 * Change the `dbname_x` to the name of your global database. For ex: `dbname_global`.
 * The new line for your global database will look something like this:

`add_db_server('global', 'dc1', 1, 1,'','111.222.333.444', 'dbname_global', 'username', 'password');`

Did you also create VIP database(s)? If so, you’ll want to add a line here too for each one.

 * Copy one of the lines generated, and paste it directly `beneath` the line for your global database.
 * Change the number at the beginning of that new line to `vip1` * Change the `dbname_x` to the name of your VIP database. For ex: `dbname_vip1`.
 * The new line for your VIP database will look something like this:

`add_db_server('vip1', 'dc1', 1, 1,'','111.222.333.444', 'dbname_vip1', 'username', 'password');`

If you have created more than one VIP database, add a similar line for each one. Change `vip1` and `dbname_vip1` in each new line to the corresponding values (`vip2`, `dbname_vip2`, etc).

**Important: If you have assigned different username(s) & password(s) to different databases in the previous steps, be sure to edit them here now for each of those databases.**

All done? Please double-check to make sure that you have the correct number of lines in there corresponding to the number of databases you created (16, 256 or 4096), as well as one for the global database, and any VIP databases you may have created too.

Now copy the entire contents of the textarea, and paste it in db-config.php at line 67, replacing all the existing examples there.

That section in your `db-config.php` should now look like this:

Again, this screenshot does not include any lines for VIP databases. But if you created some, they should be there.

![](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-db-config-3.png)


The last section we want to configure is the VIP Blogs section. This is where you will actually designate which database(s) should be used by which blog(s).

**If you did not create any databases for VIP blogs in the previous steps, you can skip this part.**

To designate a blog/site as a VIP blog/site and give it its own database, simply follow the example given at the very bottom of the file.

To add your blog with an ID of ‘4’ to the vip1 database, just enter the following: 

`add_vip_blog(4, 'vip1');`

Create a new line for each of the VIP databases you need. Paste them all in directly above the `?>` which closes the file.

![Multi-DB VIP Blogs](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-vip-blogs.png)

Note that you can only designate a VIP database for your main site if the table names are prefixed with a number, like this:
`wp_1_posts`
`wp_1_options`
etc...

However, if they do not have a numerical prefix as follows, then they cannot be moved from the global database (the table names are dependent on how/when multisite was installed).
`wp_posts`
`wp_options`
etc...

All done with db-config.php? Save your file!

## Configuring move-blogs.php
Now open `move-blogs.php` in your text editor.

This file is much simpler to configure as we only need to enter a few bits of data.

However, please take care to enter the data exactly as described below.

 * Line 19: Change `old_db_name` to the name of your current database. Following the same examples we’ve been using from the beginning, you would enter dbname here. **Important: do NOT add an underscore ( _ ) here.**
 * Line 20: If the main prefix of your current database tables is the default `wp_`, you can leave this as-is. However, if you have changed the prefix of your current database tables, enter that here.
 * Line 21: Change `newdbname` to the prefix used for all your new databases. Following the examples we’ve been using, you would enter `dbname_ `here (with the underscore this time, which designates the database prefix).
 * Line 25: Change user to the username currently associated with your database. This must not be any of the new usernames you may have created in the previous steps.
 * Line 26: Change pass to the password currently associated with your database. Again, this should not be any of the new passwords you may have created earlier.
Line 29: Change 256 to the number of databases you created at the beginning (16, 256 or 4096).

The screenshot below shows what the move-blogs.php file would look like with all the same sample data as given throughout this usage guide. Yours will, of course, contain your own data. :)

![Multi-DB Files Uploaded](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-move-blogs.png)

All done with `move-blogs.php`? Remember to save that file too.

## Uploading the Plugin Files

NOW it’s time. Here is where all our labor finally pays off. You did double and triple check everything above, right?

There are 3 files we need to upload: the 2 you just edited – `db-config.php` and `move-blogs.php` – as well as the `db.php` file which does not require any edits.

Upload both `db.php` and the `db-config.php` that you edited to your `wp-content` folder.

You can upload the files either via FTP, or use the File Manager in your cPanel.
The screenshot below shows the result of the upload via FTP using FileZilla.

![Multi-DB Files Uploaded](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-files-uploaded-1.png)

Next, we want to upload `move-blogs.php`. We recommend creating a folder inside `wp-content` called `scripts` and uploading the file there. Some hosts may prevent direct access to your `wp-content` folder, in which case you can create or move your `/scripts/` directory to the root directory of your WP installation. Your scripts directory will need execute permissions in order for this to work correctly.

It really doesn’t matter though, as long as you remember where you put it, as we’ll need to head there in our web browser next.


## Final Step: Copy & Verify DBs

We’re almost done! This last step is the one that actually copies existing tables to their respective databases according to the configuration you just completed, and ensures that new blogs/sites get properly distributed amongst those new databases.

Open up your web browser and enter the full URL to the `move-blogs.php` file on your server. If you created a scripts folder and uploaded it there, the URL would look like this (of course, replace yourdomain.com with your actual site name):

```
http://yourdomain.com/wp-content/scripts/move-blogs.php
```

You’ll see that there are 10 instructions at the top of this page.

![Multi-DB Move Blogs Tool](https://premium.wpmudev.org/wp-content/uploads/2008/08/multi-db-3240-move-blogs-tool.png)

Simply follow the instructions at the top of that screen. The main things to check are:

 * The `new db` column should display a green `exists` on each line.
 * The `status` column should show `not in new db` on each line.

When you’ve verified that everything looks right, click the link in step 5 of that screen. Once the process completes, click the link in step 7 to refresh the page. You should now see 'table in new db' under the status column for each row.

If all is good there, then you have successfully completed your multi-db installation! Congratulations!

## Upgrade Instructions

To upgrade from one version of Multi-DB to another, unless otherwise noted, you can simply upload the `db.php` file from the new version to overwrite the old one.

If you have trouble with any aspect of configuration, or if you have a cool feature suggestion to make, please head on over to the community forums where support staff and other helpful members are waiting to lend a hand.
