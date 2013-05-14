# Pure PHP5 Templates

The aims of pure PHP5 templates are: 
*   Create a templating engine without custom tags.
*   Enable Template Inheritance.

1.  [Basic Example][1]
2.  [Parent & Child Example][2]
3.  [Multi Level inheritance][3]
4.  [Additional Blocks In Children][4]
5.  [Blocks within Blocks][5]
6.  [Returning Template Content][6]
7.  [How It Works][7]
8.  [Alternatives][8]
9.  [Support][9]

<a name="1">
## Basic Example
</a>

The basic example shows how to use this on a single template. This would normally be your parent template which you could then inherit other child templates from. 

As you can see below, only one template block ("content") is defined. These blocks are the sections of template and/or code that are overwritten by the children templates. 

parent.php
```    
    <?php
        require_once('simple_template.class.php');
        $template = new simple_template();
    ?>
    <html>
        <head>
            <title>Pure PHP5 Templates Example</title>
        </head>
        <body>
            <div>
                <?php $template->startBlock("content");?>
                    <p>Basic Content</p>
                <?php $template->endBlock();?>
            </div>
        </body>
    </html>
```
The HTML generated from this template is exactly the same as it would be if you removed all the PHP code. Although it might seem onerous this is the starting point for all the following examples.


<a name="2">
## Parent & Child Example
</a>

This example shows where template inheritance comes into it's own.  
Defining blocks in a parent and then overwriting them from within the child template. I've started with the same parent template as previously shown and created a new child template. 

parent.php
```
    <?php 
        require_once('simple_template.class.php');
        $template = new simple_template(); 
    ?>
    <html>
        <head>
            <title>Pure PHP5 Templates Example</title>
        </head>
        <body>
            <div>
                <?php $template->startBlock("content");?>
                <p>Basic Content</p>
                <?php $template->endBlock();?>
            </div>
        </body>
    </html>
```

child.php
```
    <?php 
        require_once('simple_template.class.php');
        $template = simple_template::extendTemplate('parent.php');
    ?>
    <?php $template->startBlock("content");?>
        <p>New Content Within the Child Template</p>
    <?php $template->endBlock();?>
```

Below shows the output from child.php. 

```
    <html>
        <head>
            <title>Pure PHP5 Templates Example</title>
        </head>    
        <body>
            <div>
                <p>New Content Within the Child Template</p>
            </div>
        </body>
    </html>
```

<a name="3">
##  Multi Level inheritance
</a> 

The recursive design means that it's possible to have parent, child, child1, child2, ... childn. This becomes more useful when combined with the ability to have [additional blocks within child templates][4].

*Note: It's possible to overwrite a grandparent template directly from the grandchild. i.e if you set the "content" block in child1 this would overwrite the "content" block in the template parent.*

I've used the parent.php and child.php from the previous example. 

parent.php
```
    <?php 
        require_once('simple_template.class.php');
        $template = new simple_template(); 
    ?>
    <html>
        <head>
            <title>Pure PHP5 Templates Example</title>
        </head>
        <body>
            <div>
                <?php $template->startBlock("content");?>
                    <p>Basic Content</p>
                <?php $template->endBlock();?>
            </div>
        </body>
    </html>
```
child.php
```
    <?php 
        require_once('simple_template.class.php');
        $template = simple_template::extendTemplate('parent.php');
    ?>
    <?php $template->startBlock("content");?>
        <p>New Content Within the Child Template<p>
    <?php $template->endBlock();?>
```
child1.php 
```
    <?php 
        require_once('simple_template.class.php');
        $template = simple_template::extendTemplate('child.php');
    ?>
    <?php $template->startBlock("content");?>
        <p>Content Within Grandchild<p>
    <?php $template->endBlock();?>
```
Below shows the output from child1.php. 

```
    <html>
        <head>
            <title>Pure PHP5 Templates Example</title>
        </head>
        <body>
            <div>
                <p>Content Within Grandchild<p>
            </div>
        </body>
    </html>
```

<a name="4">
## Additional Blocks In Children
</a> 

This is where multi level inheritance demonstrates real value. Consider an multi section(collection of related pages) website. 

All of the sections of the website would be expected to follow one layout and colour schema. You create this in a template (Lets call it Grandparent from now on). Each section with a website may have slightly different layout. An example of this is a section might have a department column div with department name, contact number etc. This div would then appear on any of the pages within this section. The div is then placed in the template (lets call this parent) that inherits from grandparent. Now every page you create for this section inherits from parent (Lets call these children). This means that changes to the colour schema in grandparent change the colour schema in the parent and children. If you update the contact details on the parent then these change on all the children. 

This cuts down the amount of code you need to produce, no longer do you have to copy the html header, and page header or page footer etc. If you take the example if the department telephone number changes you only have to change it in one place. 

This example grandparent.php is a copy of parent.php, parent.php is based on child.php and child.php is a new template. 

Now parent.php has 2 new sections within "content", "department" and "information" and child.php now overwrites just these two new sections. 

grandparent.php
```
    <?php 
        require_once('simple_template.class.php');
        $template = new simple_template(); 
    ?>
    <html>
        <head>
            <title>Pure PHP5 Templates Example</title>
        </head>
        <body>
            <div>
                <?php $template->startBlock("content");?>
                <p>Basic Content</p>
                <?php $template->endBlock();?>
            </div>
        </body>
    </html>
```
parent.php 
```
    <?php 
        require_once('simple_template.class.php');
        $template = simple_template::extendTemplate('grandparent.php');
    ?>
    <?php $template->startBlock("content");?>
    <header>
        <?php $template->startBlock("department");?>
        <?php $template->endBlock();?>
    </header>
    <article>
        <?php $template->startBlock("information");?>
        Default Information
        <?php $template->endBlock();?>
    </article>
    <?php $template->endBlock();?>
```
child.php 
```
    <?php 
        require_once('simple_template.class.php');
        $template = simple_template::extendTemplate('parent.php');
    ?>
    <?php $template->startBlock("department");?>
        Human Resources
    <?php $template->endBlock();?>
    <?php $template->startBlock("information");?>
        HR Info.
    <?php $template->endBlock();?>
```

Below shows the output from child.php. 

```
    <html>
        <head>
            <title>Pure PHP5 Templates Example</title>
        </head>    
        <body>
            <div>
                <header>
                Human Resources
                </header>
                <article>
                HR Info.
                </article>
            </div>
        </body>
    </html>
```

<a name="5">
##  Blocks within Blocks
</a>

It's possible to have a block within a block within a block etc etc.  
The only caveat to this is that each block must have a unique name (even within children). This allows you to define various blocks within a single template and even sub blocks within a template. Then child can then inherit either a block or a single sub block. This is especially useful for areas such as Javascript. 

I have edited parent.php to add a block called "javascript" and a sub block called "additional_javascript". In parent.php I have included a standard jquery library and added a document load function to the child. 

parent.php
```
    <?php 
        require_once('simple_template.class.php');
        $template = new simple_template(); 
    ?>
    <html>
        <head>
            <title>Pure PHP5 Templates Example</title>
            <?php $template->startBlock("javascript");?>
                <script src="jquery.min.js" type="text/javascript"></script>
            
                <?php $template->startBlock("additional_javascript");?>
                <?php $template->endBlock();?>
            
            <?php $template->endBlock();?>
        </head>
        
        <body>
            <div>
                <?php $template->startBlock("content");?>
                <p>Basic Content</p>
                <?php $template->endBlock();?>
            </div>
        </body>
    </html>
```
child.php
```
    <?php 
        require_once('simple_template.class.php');
        $template = simple_template::extendTemplate('parent.php');
    ?>
    <?php $template->startBlock("additional_javascript");?>
        <script type="text/javascript">
        $(document).ready(function() {
        alert("Here");
        });
        </script>
    <?php $template->endBlock();?>
```

Below shows the output from child.php. 

```
    <html>
        <head>
            <title>Pure PHP5 Templates Example</title>
            <script src="jquery.min.js" type="text/javascript"></script>
            <script type="text/javascript">
            $(document).ready(function() {
            alert("Here");
            });
            </script>
        </head>    
        <body>
            <div>
                <p>Basic Content</p>
            </div>
        </body>
    </html>
```

An alternative option could be to overwrite the "javascript" block and add the jquery and document load function directly into this block. </section> <section> <header>

<a name="6">
##  Returning Template Content
</a> 

You may want to fetch a template into a string and then do something with that string. This example show you how to get the template content as a string. 

I have used the example from [basic example][1] and modified it to return the template to a string. 

parent.php
```
    <?php 
        require_once('simple_template.class.php');
        $template = new simple_template(); 
    ?>
    <html>
        <head>
            <title>Pure PHP5 Templates Example</title>
        </head>
        <body>
            <div>
                <?php $template->startBlock("content");?>
                <p>Basic Content</p>
                <?php $template->endBlock();?>
            </div>
        </body>
    </html>
    <?php 
    $result = $template->endTemplate();
    ?>
```

$result now contains the content of the rendered template and no output has been produced on screen. You could also do this on a child template or a grandchild etc.

<a name="7">
##  How It Works
</a> 

I'll try not to go into too much detail an just outline how the templates are split into blocks. The PHP functions used to do the templating are the [Output Control Functions][10]. 

Each PHP file is an instance of simple\_template. Each simple template has a name (the filename for the template) a parent (the filename of the parent template) and a block (simple\_block). A block then has an array of blocks each can either be a named block (One that can be overwritten by children) or a section of HTML. Each block then has an array of children blocks and so on. 

If we take the code from parent.php in the [basic example][1], the members/private variables in simple_template would be: 
*   parent: null
*   name: 'parent.php'
*   block: instance of simple_block 

If we then look at what's in the instance of simple_block, we would see: 
*   blocks/children blocks: array of mixed simple_block instances and HTML Strings
*   name: null
*   parent: instance of simple_template 
   
The main interesting point is the array of children blocks. 
If we look at this in this example we would see: 

*   0:Section Of HTML(```'<head>.....<div>'```)
*   1:Simple_Block with name "content" with an array of children (In this case containing 1 item with the HTML between the start and end)
*   2:Section Of HTML('```</div>.....</html>```') When the child overwrites sections of the parents it simply removes the simple block (in this case "content") from the parent and inserts the simple_block from the child.

<a name="9">
##  Support
</a> 

### No Output/Blank Screen

This is the most common issue I've come across. This is normally always caused by the template having either a PHP error or a exception during execution. This means that the output is never displayed from the output buffer. If you've got logging to file turned on then if you have a look in this log your find the error. 
  
As I keep having to look this up myself, adding the below to you PHP script will output errors to a file.   
```
    ini_set('log_errors',true);
    ini_set('error_log','error_log.txt');
```                  

 [1]: #1
 [2]: #2
 [3]: #3
 [4]: #4
 [5]: #5
 [6]: #6
 [7]: #7
 [8]: #8
 [9]: #9
 [10]: http://www.php.net/manual/en/ref.outcontrol.php
