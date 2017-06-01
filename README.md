# GMT EDD Automatically Create User Accounts
Automatically creates a user account when someone purchases certain products.

[Download](https://github.com/cferdinandi/gmt-edd-automatically-create-user-accounts/archive/master.zip)



## Getting Started

Getting started with Reusable Content is as simple as installing a plugin:

1. Upload the `gmt-edd-automatically-create-user-accounts` folder to the `/wp-content/plugins/` directory.
2. Activate the plugin through the Plugins menu in WordPress.
3. Under `Downloads` > `Settings` > `Extensions`, add you site URL, username, and password for the WP REST API. For security reasons, it's recommended you use the [Application Passwords plugin](https://wordpress.org/plugins/application-passwords/).

And that's it, you're done. Nice work!

It's recommended that you also install the [GitHub Updater plugin](https://github.com/afragen/github-updater) to get automattic updates.



## Displaying a customized message to the customer

Add your custom messages under `Downloads` > `Settings` > `Extensions`. There are two separate messages: one for users who already have an account, and one for users who had one newly created.

Include the `[gmt_edd_user]` shortcode on your Success Page.



## How to Contribute

Please read the [Contribution Guidelines](CONTRIBUTING.md).



## License

The code is available under the [GPLv3](LICENSE.md).