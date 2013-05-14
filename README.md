# Pure PHP5 Templates

The aims of pure PHP5 templates are: 
*   Create a templating engine without custom tags.
*   Enable Template Inheritance.

Index: 

1.  [Basic Example][1]
2.  [Parent & Child Example][2]
3.  [Multi Level inheritance][3]
4.  [Additional Blocks In Children][4]
5.  [Blocks within Blocks][5]
6.  [Returning Template Content][6]
7.  [How It Works][7]
8.  [Alternatives][8]
9.  [Support][9]</nav> <section> <header>

<a name="1">
## Basic Example
</a>

The basic example shows how to use this on a single template. This would normally be your parent template which you could then inherit other child templates from. 

As you can see below, only one template block ("content") is defined. These blocks are the sections of template and/or code that are overwritten by the children templates. 

<code>
parent.php
&lt;?php
    require_once('simple_template.class.php');
    $template = new simple_template();
    &lt;html&gt;
    &lt;head&gt;
    &lt;title&gt;Pure PHP5 Templates Example&lt;/title&gt;

              &lt;span class="tab1">&lt;/head&gt;&lt;br />&lt;/span>
            &lt;br />
              &lt;span class="tab1">&lt;body&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;div&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;?php $template->startBlock("content");?&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;p&gt;Basic Content&lt;/p&gt;&lt;/span>&lt;br />
                    &lt;span class="tab3">&lt;?php $template->endBlock();?&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;/div&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/body&gt;&lt;br />&lt;/span>
            &lt;/html&gt;&lt;br />
        </code> 
The HTML generated from this template is exactly the same as it would be if you removed all the PHP code. Although it might seem onerous this is the starting point for all the following examples. </section> <section> <header>

<a name="2"><h1>
  Parent & Child Example
</h1></a></header> 

This example shows where template inheritance comes into it's own.  
Defining blocks in a parent and then overwriting them from within the child template. I've started with the same parent template as previously shown and created a new child template. 

<code class="singlecolumn">
            &lt;header>parent.php &lt;a href="#">Show&lt;/a>&lt;/header>
            &lt;div>
            &lt;?php &lt;br />
              &lt;span class="tab1">require_once('simple_template.class.php');&lt;br />&lt;/span>
              &lt;span class="tab1">$template = new simple_template(); &lt;br />&lt;/span>
            ?&gt;&lt;br />
            &lt;html&gt;&lt;br />
              &lt;span class="tab1">&lt;head&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;title&gt;Pure PHP5 Templates Example&lt;/title&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/head&gt;&lt;br />&lt;/span>
            &lt;br />
              &lt;span class="tab1">&lt;body&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;div&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;?php $template->startBlock("content");?&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;p&gt;Basic Content&lt;/p&gt;&lt;/span>&lt;br />
                    &lt;span class="tab3">&lt;?php $template->endBlock();?&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;/div&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/body&gt;&lt;br />&lt;/span>
            &lt;/html&gt;&lt;br />
            &lt;/div>
        </code>   
<code class="singlecolumn">
            &lt;header>child.php&lt;/header>
            &lt;?php &lt;br />
              &lt;span class="tab1">require_once('simple_template.class.php');&lt;br />&lt;/span>
              &lt;span class="tab1">$template = simple_template::extendTemplate('parent.php');&lt;br />&lt;/span>
            ?&gt;&lt;br />
            &lt;?php $template->startBlock("content");?&gt;&lt;br />
            &lt;span class="tab1">&lt;p&gt;New Content Within the Child Template&lt;/p&gt;&lt;br />&lt;/span>
            &lt;?php $template->endBlock();?&gt;&lt;br />
        </code>   
Below shows the output from child.php. 

<code class="singlecolumn">
            &lt;header>OUTPUT&lt;/header>
            &lt;div>
            &lt;html&gt;&lt;br />
              &lt;span class="tab1">&lt;head&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;title&gt;Pure PHP5 Templates Example&lt;/title&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/head&gt;&lt;br />&lt;/span>
            &lt;br />
              &lt;span class="tab1">&lt;body&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;div&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;p&gt;New Content Within the Child Template&lt;/p&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;/div&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/body&gt;&lt;br />&lt;/span>
            &lt;/html&gt;&lt;br />
            &lt;/div>
        </code> <br style="clear:left;" /> </section> <section> <header><a name="3"><h1>
  Multi Level inheritance
</h1></a></header> 

The recursive design means that it's possible to have parent, child, child1, child2, ... childn. This becomes more useful when combined with the ability to have [additional blocks within child templates][4]. <aside class="note"> 

## Note: It's possible to overwrite a grandparent template directly from the grandchild. i.e if you set the "content" block in child1 this would overwrite the "content" block in the template parent. </aside> 

I've used the parent.php and child.php from the previous example. 

<code class="singlecolumn">
            &lt;header>parent.php &lt;a href="#">Show&lt;/a>&lt;/header>
            &lt;div>
            &lt;?php &lt;br />
              &lt;span class="tab1">require_once('simple_template.class.php');&lt;br />&lt;/span>
              &lt;span class="tab1">$template = new simple_template(); &lt;br />&lt;/span>
            ?&gt;&lt;br />
            &lt;html&gt;&lt;br />
              &lt;span class="tab1">&lt;head&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;title&gt;Pure PHP5 Templates Example&lt;/title&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/head&gt;&lt;br />&lt;/span>
            &lt;br />
              &lt;span class="tab1">&lt;body&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;div&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;?php $template->startBlock("content");?&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;p&gt;Basic Content&lt;/p&gt;&lt;/span>&lt;br />
                    &lt;span class="tab3">&lt;?php $template->endBlock();?&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;/div&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/body&gt;&lt;br />&lt;/span>
            &lt;/html&gt;&lt;br />
            &lt;/div>
        </code>   
<code class="singlecolumn">
            &lt;header>child.php &lt;a href="#">Show&lt;/a>&lt;/header>
            &lt;div>
            &lt;?php &lt;br />
              &lt;span class="tab1">require_once('simple_template.class.php');&lt;br />&lt;/span>
              &lt;span class="tab1">$template = simple_template::extendTemplate('parent.php');&lt;br />&lt;/span>
            ?&gt;&lt;br />
            &lt;?php $template->startBlock("content");?&gt;&lt;br />
            &lt;span class="tab1">&lt;p&gt;New Content Within the Child Template&lt;p&gt;&lt;br />&lt;/span>
            &lt;?php $template->endBlock();?&gt;&lt;br />
            &lt;/div>
        </code>   
<code class="singlecolumn">
            &lt;header>child1.php&lt;/header>
            &lt;?php &lt;br />
              &lt;span class="tab1">require_once('simple_template.class.php');&lt;br />&lt;/span>
              &lt;span class="tab1">$template = simple_template::extendTemplate('child.php');&lt;br />&lt;/span>
            ?&gt;&lt;br />
            &lt;?php $template->startBlock("content");?&gt;&lt;br />
            &lt;span class="tab1">&lt;p&gt;Content Within Grandchild&lt;p&gt;&lt;br />&lt;/span>
            &lt;?php $template->endBlock();?&gt;&lt;br />
        </code>   
Below shows the output from child1.php. 

<code class="singlecolumn">
            &lt;header>OUTPUT&lt;/header>
            &lt;div>
            &lt;html&gt;&lt;br />
              &lt;span class="tab1">&lt;head&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;title&gt;Pure PHP5 Templates Example&lt;/title&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/head&gt;&lt;br />&lt;/span>
            &lt;br />
              &lt;span class="tab1">&lt;body&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;div&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;p&gt;Content Within Grandchild&lt;p&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;/div&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/body&gt;&lt;br />&lt;/span>
            &lt;/html&gt;&lt;br />
            &lt;/div>
        </code> <br style="clear:left;" /> </section> <section> <header><a name="4"><h1>
  Additional Blocks In Children
</h1></a></header> 

This is where multi level inheritance demonstrates real value. Consider an multi section(collection of related pages) website. 

All of the sections of the website would be expected to follow one layout and colour schema. You create this in a template (Lets call it Grandparent from now on). Each section with a website may have slightly different layout. An example of this is a section might have a department column div with department name, contact number etc. This div would then appear on any of the pages within this section. The div is then placed in the template (lets call this parent) that inherits from grandparent. Now every page you create for this section inherits from parent (Lets call these children). This means that changes to the colour schema in grandparent change the colour schema in the parent and children. If you update the contact details on the parent then these change on all the children. 

This cuts down the amount of code you need to produce, no longer do you have to copy the html header, and page header or page footer etc. If you take the example if the department telephone number changes you only have to change it in one place. 

This example grandparent.php is a copy of parent.php, parent.php is based on child.php and child.php is a new template. 

Now parent.php has 2 new sections within "content", "department" and "information" and child.php now overwrites just these two new sections. 

<code class="singlecolumn">
            &lt;header>grandparent.php &lt;a href="#">Show&lt;/a>&lt;/header>
            &lt;div>
            &lt;?php &lt;br />
              &lt;span class="tab1">require_once('simple_template.class.php');&lt;br />&lt;/span>
              &lt;span class="tab1">$template = new simple_template(); &lt;br />&lt;/span>
            ?&gt;&lt;br />
            &lt;html&gt;&lt;br />
              &lt;span class="tab1">&lt;head&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;title&gt;Pure PHP5 Templates Example&lt;/title&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/head&gt;&lt;br />&lt;/span>
            &lt;br />
              &lt;span class="tab1">&lt;body&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;div&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;?php $template->startBlock("content");?&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;p&gt;Basic Content&lt;/p&gt;&lt;/span>&lt;br />
                    &lt;span class="tab3">&lt;?php $template->endBlock();?&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;/div&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/body&gt;&lt;br />&lt;/span>
            &lt;/html&gt;&lt;br />
            &lt;/div>
        </code>   
<code class="singlecolumn">
            &lt;header>parent.php&lt;/header>
            &lt;?php &lt;br />
              &lt;span class="tab1">require_once('simple_template.class.php');&lt;br />&lt;/span>
              &lt;span class="tab1">$template = simple_template::extendTemplate('grandparent.php');&lt;br />&lt;/span>
            ?&gt;&lt;br />
            &lt;?php $template->startBlock("content");?&gt;&lt;br />
            
            &lt;span class="tab1">&lt;header&gt;&lt;br/>&lt;/span>
            &lt;span class="tab2">&lt;?php $template->startBlock("department");?&gt;&lt;br />&lt;/span>
            &lt;span class="tab2">&lt;?php $template->endBlock();?&gt;&lt;br/>&lt;/span>
            &lt;span class="tab1">&lt;/header&gt;&lt;br/>&lt;/span>

            &lt;span class="tab1">&lt;article&gt;&lt;br/>&lt;/span>
            &lt;span class="tab2">&lt;?php $template->startBlock("information");?&gt;&lt;br />&lt;/span>
            &lt;span class="tab3">Default Information&lt;br />&lt;/span>
            &lt;span class="tab2">&lt;?php $template->endBlock();?&gt;&lt;br/>&lt;/span>
            &lt;span class="tab1">&lt;/article&gt;&lt;br/>&lt;/span>

            &lt;?php $template->endBlock();?&gt;&lt;br />
        </code>   
<code class="singlecolumn">
            &lt;header>child.php&lt;/header>
            &lt;?php &lt;br />
              &lt;span class="tab1">require_once('simple_template.class.php');&lt;br />&lt;/span>
              &lt;span class="tab1">$template = simple_template::extendTemplate('parent.php');&lt;br />&lt;/span>
            ?&gt;&lt;br />
            &lt;?php $template->startBlock("department");?&gt;&lt;br />
            &lt;span class="tab1">Human Resources&lt;br />&lt;/span>
            &lt;?php $template->endBlock();?&gt;&lt;br />
            &lt;?php $template->startBlock("information");?&gt;&lt;br />
            &lt;span class="tab1">HR Info.&lt;br />&lt;/span>
            &lt;?php $template->endBlock();?&gt;&lt;br />
        </code> 
Below shows the output from child.php. 

<code class="singlecolumn">
            &lt;header>OUTPUT&lt;/header>
            &lt;div>
            &lt;html&gt;&lt;br />
              &lt;span class="tab1">&lt;head&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;title&gt;Pure PHP5 Templates Example&lt;/title&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/head&gt;&lt;br />&lt;/span>
            &lt;br />
              &lt;span class="tab1">&lt;body&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;div&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;header&gt;&lt;br/>&lt;/span>
                        &lt;span class="tab4">Human Resources&lt;br />&lt;/span>                
                    &lt;span class="tab3">&lt;/header&gt;&lt;br/>&lt;/span>
                    &lt;span class="tab3">&lt;article&gt;&lt;br/>&lt;/span>
                        &lt;span class="tab4">HR Info.&lt;br />&lt;/span>                    
                    &lt;span class="tab3">&lt;/article&gt;&lt;br/>&lt;/span>
                &lt;span class="tab2">&lt;/div&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/body&gt;&lt;br />&lt;/span>
            &lt;/html&gt;&lt;br />
            &lt;/div>
        </code> <br style="clear:left;" /> </section> <section> <header><a name="5"><h1>
  Blocks within Blocks
</h1></a></header> 

It's possible to have a block within a block within a block etc etc.  
The only caveat to this is that each block must have a unique name (even within children). This allows you to define various blocks within a single template and even sub blocks within a template. Then child can then inherit either a block or a single sub block. This is especially useful for areas such as Javascript. 

I have edited parent.php to add a block called "javascript" and a sub block called "additional_javascript". In parent.php I have included a standard jquery library and added a document load function to the child. 

<code class="singlecolumn">
            &lt;header>parent.php&lt;/header>
            &lt;div>
            &lt;?php &lt;br />
              &lt;span class="tab1">require_once('simple_template.class.php');&lt;br />&lt;/span>
              &lt;span class="tab1">$template = new simple_template(); &lt;br />&lt;/span>
            ?&gt;&lt;br />
            &lt;html&gt;&lt;br />
              &lt;span class="tab1">&lt;head&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;title&gt;Pure PHP5 Templates Example&lt;/title&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;?php $template->startBlock("javascript");?&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;script src="jquery.min.js" type="text/javascript"&gt;&lt;/script&gt;&lt;/span>&lt;br />&lt;br/>
                    &lt;span class="tab3">&lt;?php $template->startBlock("additional_javascript");?&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;?php $template->endBlock();?&gt;&lt;br />&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;?php $template->endBlock();?&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/head&gt;&lt;br />&lt;/span>
            &lt;br />
              &lt;span class="tab1">&lt;body&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;div&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;?php $template->startBlock("content");?&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;p&gt;Basic Content&lt;/p&gt;&lt;/span>&lt;br />
                    &lt;span class="tab3">&lt;?php $template->endBlock();?&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;/div&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/body&gt;&lt;br />&lt;/span>
            &lt;/html&gt;&lt;br />
            &lt;/div>
        </code>   
<code class="singlecolumn">
            &lt;header>child.php&lt;/header>
            &lt;?php &lt;br />
              &lt;span class="tab1">require_once('simple_template.class.php');&lt;br />&lt;/span>
              &lt;span class="tab1">$template = simple_template::extendTemplate('parent.php');&lt;br />&lt;/span>
            ?&gt;&lt;br />
            &lt;?php $template->startBlock("additional_javascript");?&gt;&lt;br />
            &lt;span class="tab1">&lt;script type="text/javascript"&gt;&lt;br />&lt;/span>
            &lt;span class="tab2">$(document).ready(function() {&lt;br />&lt;/span>
            &lt;span class="tab3">alert("Here");&lt;br />&lt;/span>
            &lt;span class="tab2">});&lt;br />&lt;/span>
            &lt;span class="tab1">&lt;/script&gt;&lt;br />&lt;/span>                    
            &lt;?php $template->endBlock();?&gt;&lt;br/>
        </code> 
Below shows the output from child.php. 

<code class="singlecolumn">
            &lt;header>OUTPUT&lt;/header>
            &lt;div>
            &lt;html&gt;&lt;br />
              &lt;span class="tab1">&lt;head&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;title&gt;Pure PHP5 Templates Example&lt;/title&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;script src="jquery.min.js" type="text/javascript"&gt;&lt;/script&gt;&lt;/span>&lt;br />
                &lt;span class="tab2">&lt;script type="text/javascript"&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">$(document).ready(function() {&lt;br />&lt;/span>
                &lt;span class="tab3">alert("Here");&lt;br />&lt;/span>
                &lt;span class="tab2">});&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;/script&gt;&lt;br />&lt;/span>  
              &lt;span class="tab1">&lt;/head&gt;&lt;br />&lt;/span>
            &lt;br />
              &lt;span class="tab1">&lt;body&gt;&lt;br />&lt;/span>
                &lt;span class="tab2">&lt;div&gt;&lt;br />&lt;/span>
                    &lt;span class="tab3">&lt;p&gt;Basic Content&lt;/p&gt;&lt;/span>&lt;br />
                &lt;span class="tab2">&lt;/div&gt;&lt;br />&lt;/span>
              &lt;span class="tab1">&lt;/body&gt;&lt;br />&lt;/span>
            &lt;/html&gt;&lt;br />
            &lt;/div>
        </code> 
An alternative option could be to overwrite the "javascript" block and add the jquery and document load function directly into this block. </section> <section> <header>

<a name="6"><h1>
  Returning Template Content
</h1></a></header> 

You may want to fetch a template into a string and then do something with that string. This example show you how to get the template content as a string. 

I have used the example from [basic example][1] and modified it to return the template to a string. 

<code class="singlecolumn">
                &lt;header>parent.php&lt;/header>
                &lt;?php &lt;br />
                  &lt;span class="tab1">require_once('simple_template.class.php');&lt;br />&lt;/span>
                  &lt;span class="tab1">$template = new simple_template(); &lt;br />&lt;/span>
                ?&gt;&lt;br />
                &lt;html&gt;&lt;br />
                  &lt;span class="tab1">&lt;head&gt;&lt;br />&lt;/span>
                    &lt;span class="tab2">&lt;title&gt;Pure PHP5 Templates Example&lt;/title&gt;&lt;br />&lt;/span>
                  &lt;span class="tab1">&lt;/head&gt;&lt;br />&lt;/span>
                &lt;br />
                  &lt;span class="tab1">&lt;body&gt;&lt;br />&lt;/span>
                    &lt;span class="tab2">&lt;div&gt;&lt;br />&lt;/span>
                        &lt;span class="tab3">&lt;?php $template->startBlock("content");?&gt;&lt;br />&lt;/span>
                        &lt;span class="tab3">&lt;p&gt;Basic Content&lt;/p&gt;&lt;/span>&lt;br />
                        &lt;span class="tab3">&lt;?php $template->endBlock();?&gt;&lt;br />&lt;/span>
                    &lt;span class="tab2">&lt;/div&gt;&lt;br />&lt;/span>
                  &lt;span class="tab1">&lt;/body&gt;&lt;br />&lt;/span>
                &lt;/html&gt;&lt;br />
                &lt;?php &lt;br />
                  &lt;span class="tab1">$result = $template->endTemplate();&lt;br />&lt;/span>
                ?&gt;&lt;br />
            </code> 
$result now contains the content of the rendered template and no output has been produced on screen. You could also do this on a child template or a grandchild etc. </section> <section> <header>

<a name="7"><h1>
  How It Works
</h1></a></header> 

I'll try not to go into too much detail an just outline how the templates are split into blocks. The PHP functions used to do the templating are the [Output Control Functions][10]. 

Each PHP file is an instance of simple\_template. Each simple template has a name (the filename for the template) a parent (the filename of the parent template) and a block (simple\_block). A block then has an array of blocks each can either be a named block (One that can be overwritten by children) or a section of HTML. Each block then has an array of children blocks and so on. 

If we take the code from parent.php in the [basic example][1], the members/private variables in simple_template would be: 
*   parent: null
*   name: 'parent.php'
*   block: instance of simple_block If we then look at what's in the instance of simple_block, we would see: 

*   blocks: array of mixed simple_block instances and HTML Strings
*   name: null
*   parent: instance of simple_template The main interesting point is the array of children blocks. If we look at this in this example we would see: 

*   0:Section Of HTML('<head>.....<div>')
*   1:Simple_Block with name "content" with an array of children (In this case containing 1 item with the HTML between the start and end)
*   2:Section Of HTML('</div>.....</html>') When the child overwrites sections of the parents it simply removes the simple block (in this case "content") from the parent and inserts the simple_block from the child. </section> <section> <header>

<a name="8"><h1>
  Alternatives
</h1></a></header> 

There are loads of [templating engines out on the web][11]. If your starting out **I wouldn't**, recommend using mine. 

My reasoning behind this is that although mine might be faster, quicker to get started with, already designed around PHP5 etc (I haven't done any speed test etc). It doesn't help enforce good practice. You can still write business logic in the middle of a template and unlike other templating systems is hard to debug. 

When I started my exploration of PHP templating I started out using [Smarty][12], make sure you leave PHP tags off and your soon realise your getting something wrong when you suddenly want to put PHP directly into a template. I'm sure this is a case with a lot of the other templating systems but I've only ever used this and [Smarty][12]. </section> <section> <header>

<a name="9"><h1>
  Support
</h1></a></header> 

*   [No Output/Blank Screen][13]
*   [Contributing][14]
*   [Bug Reporting][15]
*   [Other Issues][16]<section> <header>

[
## No Output/Blank Screen][17]</header> This is the most common issue I've come across. This is normally always caused by the template having either a PHP error or a exception during execution. This means that the output is never displayed from the output buffer. If you've got logging to file turned on then if you have a look in this log your find the error. 

  
  
As I keep having to look this up myself, adding the below to you PHP script will output errors to a file.   
`
                  ini_set('log_errors',true);<br />
                  ini_set('error_log','error_log.txt');
                ` </section>   
<section> <header>[
## Contributing][18]</header> If you want to contribute fixes or enhancements towards this project please drop me a message using the 

[contact me][19]. Let me know if you want recognition in the source code or on future release notes. If you want an email or contact website included let me know. </section>   
<section> <header>[
## Bug Reporting][20]</header> <aside style="width:100px;min-height:80px;"> 

**Long Term**  
I'm thinking of adding a forum plugin to [Content CMS][21]. When this is complete I'll create a forum for it. </aside> If you've found an issue with the code and are able reproduce it if you drop me a message using the [contact me][19] page I'll email you back.   
</section>   
<section> <header>[
## Other Issues][22]</header> Officially I'm not offering any kind of support however, if you 

[drop me a message][19] I'll try to get back to you within 24 hours.   
</section> </section> </article>

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
 [11]: http://en.wikipedia.org/wiki/Template_engine_%28web%29
 [12]: http://smarty.net
 [13]: #support_1
 [14]: #support_2
 [15]: #support_3
 [16]: #support_4
 [17]: support_1
 [18]: support_2
 [19]: index.php?plugin=home&action=contact
 [20]: support_3
 [21]: index.php?plugin=home&action=projects
 [22]: support_4
