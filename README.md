## Coffee Helper

This little Helper converts your .coffee files into .js without relying on Node.js or client-side parsing.
Everything is compiled on the server, cached, and served as regular js through using the [coffeescript-php](https://github.com/alxlit/coffeescript-php) compiler.

## Installation

### Get the files in place

Clone from github: in your plugin directory type `git clone https://github.com/Hyra/Coffee-Cake.git Coffee`
You should end up having a folder `app/Plugin/Coffee`

### Create the coffee folder

- Create a folder called `coffee` in `app/webroot/`
- Optionally apply `chmod 777` to your `js` folder. (The Coffee Helper will place all compiled js files in your js-directory.)

## Usage
Where you want to use Coffee files, add the helper. Usually this will be your `AppController`.

	public $helpers = array('Coffee.Coffee');

Next, simply add the Coffee files to your views:

	echo $this->Coffee->script('yourfile');
	
or
	
	echo $this->Coffee->script(array(
			'somedir/somefile',
			'awesome_script',
		)
	);

That's it.

