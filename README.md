# GenPainterPE
Pocketmine Generator for Earth and heightmap based generation.

## What is GenPainterPE?
GenPainterPE is a PocketMine plugin which allows you to generate minecraft maps just with an heightmap.

## How to use GenPainterPE?
First, look at [the installation part](#installation).     
Creating a world would take the default config.yml settings, and then apply them to map creation (note: changing theses settings afterwards won't change them for the map. You should regenerate one another to change settings).    
To create a world, you can go to your pocketmine.yml, and at the end of the file, add a new world with the generator "genpainter".

## Customizing GenPainterPE
You can customize GenPainterPE's generation by modifing some values in the config.yml.    
<a id="add-heightmap"></a>    
You can also <b>add your own heightmap</b>. [What is an heightmap?](https://en.wikipedia.org/wiki/Heightmap)    
How to do that? 
1. Get your heightmap in a png form (.png)
2. Put it into the GenPainterPE/heightmaps folder
3. Change the "heightmap_name" in the config.yml to the name of your heightmap (WITHOUT THE .png AT THE END)
4. Create a new world with the genpainter generator     

(note: you can modify your config afterwards and remove the .png as the world heightmap and data has been saved to your generated map)


## Installation
Note: This section is only for *nix users (Linux, MacOS, Unix, FreeBSD). PMMP's windows' prebuilt binaries includes GD by default.    
To support all the features including your own heightmap creation, you may need to install the PHP GD extension.    
Don't have it and don't know how to install it?
- For PocketMine Server Manager users, check if the plugin is working, if not, just delete the folder located in &lt;YOUR\_OWN\_FOLDER&gt;/.pocketmine/php and restart PocketMine Server Manager.
- For regular pocketmine user, you can get <a href="https://psm.mcpe.fun/download/PHP/compile.sh">the following script to install a PHP with GD included </a>.

You may also need to install https://sourceforge.net/projects/libpng/.
