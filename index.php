<?php
include_once 'includes/php/config.php';
?>

<!DOCTYPE html>
<html>

<head>

    <title>HyperBlocks Editor <?=$GLOBALS['version'];?></title>
    <link href="http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300" rel="stylesheet" type="text/css">
    <link href="<?=$GLOBALS['base_url']?>includes/css/stylesheet.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div id="wrapper">

        <div class="column-wrapper"><div class="column">

            <div class="tabs"><div class="tab full">HyperBlocks Editor <span><?=$GLOBALS['version'];?></div></div>

            <div class="scroll-wrapper"><div class="scroll">

                <p>Hello there, welcome to the HyperBlocks editor! To find out more about HyperBlocks, check out <a href="http://www.reddit.com/r/HyperBlocks" target="_blank">/r/HyperBlocks</a>.</p>

                <p>Thanks to this editor you don't have to know anything about CSS or HyperBlocks' syntax, just drag & drop presets from the neighbouring column onto your sidebar and edit their settings.</p>

                <p>For HyperBlocks to work, you need to add HyperBlocks' CSS to the end of your stylesheet and upload the icon sprite to your subreddit.</p>

                <a id="get-css" href="#get-css">Get the CSS</a>

                <a id="get-sprite" href="#get-sprite">Get the sprite</a>

                <p>As soon as you've finished customising your sidebar, click the button below to generate Markdown syntax that can later be copied & pasted into the sidebar text area in your subreddit's settings.</p>

                <a id="generate-markdown" href="#generate-markdown">Generate Markdown syntax</a>

                <p>At the moment this editor can't import the generated Markdown syntax, so if you want to edit you sidebar in the future you must export and save it somewhere. To edit it again, just import it into the editor.</p>

                <a id="export-sidebar" href="#export-sidebar">Export your sidebar</a>

                <a id="import-sidebar" href="#import-sidebar">Import your sidebar</a>


            </div></div>

        </div></div><!--

     --><div class="column-wrapper"><div id="presets-column" class="column">

            <div class="tabs"><div class="tab full">Presets</div></div>

            <div id="presets-scroll-wrapper" class="scroll-wrapper"><div class="scroll">

                <p>Drag & drop presets from here to your sidebar.</p>

                <div id="presets">

                    <div class="hyperblock block heading text" data-colour="gray">
                        <pre class="markdown-hidden heading-markdown">HyperBlock with a *Heading*</pre>
                        <h1 class="heading">HyperBlock with a <i>Heading</i></h1>
                        <pre class="markdown-hidden text-markdown">...and some text.</pre>
                        <div class="text"><p>...and some text.</p></div>
                    </div>

                    <div class="hyperblock block heading" data-colour="gray">
                        <pre class="markdown-hidden heading-markdown">HyperBlock with a *Heading*</pre>
                        <h1 class="heading">HyperBlock with a <i>Heading</i></h1>
                    </div>

                    <div class="hyperblock block text" data-colour="gray">
                        <pre class="markdown-hidden text-markdown">Paste your *markdown* here!</pre>
                        <div class="text"><p>Paste your <i>markdown</i> here!</p></div>
                    </div>

                    <div class="hyperblock block heading text" data-colour="gray">
                        <pre class="markdown-hidden heading-markdown">HyperBlock with a *Heading*</pre>
                        <h1 class="heading">HyperBlock with a <i>Heading</i></h1>
                        <pre class="markdown-hidden text-markdown">* Example<?=PHP_EOL;?><?=PHP_EOL;?>* of a<?=PHP_EOL;?><?=PHP_EOL;?>* list</pre>
                        <div class="text"><p><ul><li>Example</li><li>of a</li><li>list</li></ul></p></div>
                    </div>

                    <div class="hyperblock button" data-colour="transparent">
                        <pre class="markdown-hidden button-markdown">A **HyperButton**</pre>
                        <a href="#HyperButton" title="A tooltip." data-colour="gray" class="button">A <strong>HyperButton</strong></a>
                    </div>

                </div>

            </div></div>

        </div></div><!--

     --><div class="column-wrapper"><div id="sidebar" class="column">

            <div class="scroll-wrapper"><div class="scroll">

                <div id="sidebar-top">

                    <div class="submit">Submit a new link</div>

                    <div class="submit">Submit a new text post</div>

                    <div class="subreddit">YourSidebar</div>

                    <div class="subscribe">Subscribe</div> <div class="readers">3,141 readers</div>

                    <div class="users">~1 user here now</div>

                </div>

                <div id="sidebar-md">



                </div>

            </div></div>


        </div></div><!--

     --><div id="properties-wrapper" class="column-wrapper"><div id="properties-column" class="column">

            <div class="tabs"><div class="tab full">Properties</div></div>

            <div id="properties-scroll-wrapper" class="scroll-wrapper"><div class="scroll">

                    <a id="clear-sidebar" class="important" href="#clear-sidebar">Clear the sidebar</a>

                    <p>Click on a preset in your sidebar once to edit its properties.</p>

                    <div id="properties">



                    </div>

            </div></div>

        </div></div>

    </div>

    <script src="<?=$GLOBALS['base_url']?>includes/js/jquery-2.1.3.min.js"></script>
    <script src="<?=$GLOBALS['base_url']?>includes/js/jquery-ui.min.js"></script>
    <script src="<?=$GLOBALS['base_url']?>includes/js/jquery.cookie.js"></script>
    <script src="<?=$GLOBALS['base_url']?>includes/js/marked.js"></script>
    <script>
        // Warning about cookies usage
        // TODO

        var hbVersion = '0.2';
        var hbColours = [];
        hbColours['azure'] = '#007fff';
        hbColours['golden'] = '#ffd700';
        hbColours['gray'] = '#cccccc';
        hbColours['magenta'] = '#ff0090';
        hbColours['mantis'] = '#74C365';
        hbColours['orangered'] = '#ff4500';
        hbColours['plum'] = '#843179';
        hbColours['red'] = '#ff0000';
        hbColours['teal'] = '#008080';

        var body = $('body');

        // Responsiveness Simulator 2015
        var wideMode = true;
        resizeEditor();
        $(window).resize(function() {
            resizeEditor();
        });
        function resizeEditor() {
            var wrapper = $('#wrapper');
            var presetsColumn = $('#presets-column');
            var presetsScroll = $('#presets-scroll-wrapper');
            var propertiesWrapper = $('#properties-wrapper');
            var propertiesColumn = $('#properties-column');
            var propertiesScroll = $('#properties-scroll-wrapper');
            if(wrapper.width() < 1400 && wideMode) {

                wideMode = false;
                propertiesWrapper.css('display', 'none');
                presetsColumn.find('.tabs').html('<div id="presets-tab" data-tab="presets" class="tab half active">Presets</div><div id="properties-tab" data-tab="properties" class="tab half clickable inactive">Properties</div>');
                propertiesScroll.appendTo(presetsColumn);
                propertiesScroll.css('display', 'none');

            } else if(wrapper.width() >= 1400 && !wideMode) {

                wideMode = true;
                propertiesWrapper.css('display', 'inline-block');
                presetsColumn.find('.tabs').html('<div class="tab full">Presets</div>');
                propertiesScroll.appendTo(propertiesColumn);
                presetsScroll.css('display', 'block');
                propertiesScroll.css('display', 'block');

            }
        }
        body.on('click', '.tab.clickable', function() {
            if(wideMode) return;
            chooseTab($(this).data('tab'));
        });
        function chooseTab(tab) {
            var otherTab = 'presets';
            if(tab == otherTab) otherTab = 'properties';
            $('#' + otherTab + '-tab').addClass('clickable').removeClass('active').addClass('inactive');
            $('#' + tab + '-tab').removeClass('clickable').addClass('active').removeClass('inactive');
            $('#' + otherTab + '-scroll-wrapper').css('display', 'none');
            $('#' + tab + '-scroll-wrapper').css('display', 'block');
        }


        // Buttons
        $('#get-css').click(function() {
            window.open("<?=$GLOBALS['base_url']?>includes/css/HyperBlocks.css?v" + hbVersion, "", "width=500, height=500, location=0, resizable=1, menubar=0, scrollbars=0");
        });
        $('#get-sprite').click(function() {
            window.open("<?=$GLOBALS['base_url']?>images/hb-sprite.png?v" + hbVersion, "", "width=500, height=500, location=0, resizable=1, menubar=0, scrollbars=0");
        });

        // HyperBlocks compiler
        $('#generate-markdown').click(function() {
            var markdown = '';
            $('#sidebar-md').find('.hyperblock').each(function(index) {
                if(index != 0) {
                    markdown += '\n\n.';
                }
                markdown += '\n> .';
                var hyperblock = $(this);

                var colour = hyperblock.attr('data-colour');
                if(colour != null)
                    markdown += '[](#hb-block-' + colour +')';
                if(hyperblock.hasClass('heading'))
                    markdown += '\n>> # ' + hyperblock.find('.heading-markdown').text();
                if(hyperblock.hasClass('text')) {
                    markdown += '\n>> ' + hyperblock.find('.text-markdown').text().replace(/(\r\n|\n|\r)/gm, '\n>>');
                }
                if(hyperblock.hasClass('button')) {
                    var button = hyperblock.find('.button');
                    var tooltip = button.attr('title').replace('\'', '\\\'');
                    markdown += '\n>> [](#hb-button-' + button.attr('data-colour') + ')[' + hyperblock.find('.button-markdown').text() + '](' + button.attr('href') +' \'' + tooltip + '\')';
                }

            });
            var w = window.open("HyperBlocks Markdown","_blank","width=750, height=400, location=0, resizable=1, menubar=0, scrollbars=0");
            w.document.write("<textarea style=\"width:99%;height:99%\">" + markdown + "</textarea>");
            w.document.close();
        });

        // Import/export
        var checkContent = ['heading', 'text', 'button', 'button:href', 'button:title'];
        var exportImportVersion = '0.1';
        if($.cookie('hbSidebar') != null)
            hbImport($.cookie('hbSidebar'), true);
        $('#export-sidebar').click(function(e) {
            e.preventDefault();
            hbExport('window');
        });
        function hbExport(target) {
            var hyperblocks = [];
            $('#sidebar-md').find('.hyperblock').each(function(index) {

                var object = $(this);
                var type = 'block';
                if(object.hasClass('button'))
                    type = 'button';
                var colour = 'transparent';
                if(type == 'block')
                    colour = object.attr('data-colour');
                if(type == 'button')
                    colour = object.find('.button').attr('data-colour');

                var content = [];
                for(var i in checkContent) {
                    var target = checkContent[i].split(':');
                    if(!object.hasClass(target[0])) continue;
                    if(target.length == 1)
                        content.push([checkContent[i], object.find('.' + target[0] + '-markdown').text()]);
                    else
                        content.push([checkContent[i], object.find('.' + target[0]).attr(target[1])]);
                }
                hyperblocks.push({
                    type: type,
                    colour: colour,
                    content: content
                });
            });
            var exportOutput = {
                version: exportImportVersion,
                hyperblocks: hyperblocks
            };
            var json = JSON.stringify(exportOutput);
            if(target == 'window') {
                var w = window.open("HyperBlocks JSON","_blank","width=750, height=400, location=0, resizable=1, menubar=0, scrollbars=0");
                w.document.write("<textarea style=\"width:99%;height:99%\">" + json + "</textarea>");
                w.document.close();
            }
            if(target == 'cookie')
                $.cookie('hbSidebar', json);
        }
        $('#import-sidebar').click(function(e) {
            e.preventDefault();
            var json = prompt("Please paste JSON here:");
            if(json != null)
                hbImport(json, false);
        });
        function hbImport(json, autoload) {
            var sidebar = $('#sidebar-md');
            if(sidebar.find('.hyperblock').length != 0 && !confirm('Your sidebar contains HyperBlocks. If you\'ll choose to continue, any changes you\'ve made will be deleted irrecoverably. Are you sure you want to continue?'))
                return;
            var parsedJSON = JSON.parse(json);
            if(parsedJSON.version != exportImportVersion)
                alert('HyperBlocks were exported using an older version of the editor. The editor will still attempt to import the content.');
            if(parsedJSON.hyperblocks.length == 0) {
                if(!autoload) alert('Imported JSON doesn\'t contain any HyperBlocks.');
                return;
            }
            sidebar.html('');
            for(i in parsedJSON.hyperblocks) {
                var hyperblockJSON = parsedJSON.hyperblocks[i];
                var hyperblock = $('<div class="hyperblock" data-colour="gray"></div>');
                if(hyperblockJSON.type == 'block')
                    hyperblock.addClass('block');
                if(hyperblockJSON.type == 'button')
                    hyperblock.addClass('button');
                for(var i in checkContent) {
                    var _set = hyperblockJSON.content[i];
                    if(_set == null) continue;
                    var value = _set[1];
                    if(value == null) continue;
                    var target = _set[0].split(':');
                    if(!hyperblock.hasClass(target[0]))
                        hyperblock.addClass(target[0]);
                    if(target.length == 1) {
                        var tags = {
                            heading: 'h1',
                            text: 'div',
                            button: 'a'
                        };
                        hyperblock.append('<pre class="markdown-hidden ' + target[0] + '-markdown">' + value + '</pre>' +
                            '<' + tags[target[0]] + ' class="' + target[0] + '">' + marked(value) + '</' + tags[target[0]] + '>');
                    }
                    else
                        hyperblock.find('.' + target[0]).attr(target[1], value);
                }
                var colour = hyperblockJSON.colour;
                if(hyperblockJSON.type == 'block')
                    hyperblock.attr('data-colour', colour);
                if(hyperblockJSON.type == 'button')
                    hyperblock.find('.button').attr('data-colour', colour);
                sidebar.append(hyperblock);
            }
        }

        // Sidebar stuff
        $(function() {
            $("#sidebar-md").sortable({
                placeholder: "placeholder",
                start: function(e, ui){
                    ui.placeholder.height(ui.item.height() + 20);
                },
                stop: function(event,ui){
                    ui.item.height("auto");
                    hbExport('cookie');
                },
                containment: 'window',
                appendTo: 'body',
                helper: "clone",
                scroll: false,
                revert: true,
                distance: 15
            });
            $("#presets").find(".hyperblock").draggable({
                connectToSortable: "#sidebar-md",
                stop: function(event,ui){
                    hbExport('cookie');
                },
                containment: 'window',
                dropOnEmpty: true,
                revert: "invalid",
                appendTo: 'body',
                helper: "clone",
                cursor: "move",
                scroll: false,
                distance: 15
            });
        });

        // Properties target + selection
        var propertiesTarget = null;
        $('#sidebar-md').on('click', '.hyperblock', function() {
            if(propertiesTarget != null)
                propertiesTarget.target.removeClass('selected');
            var target = $(this).addClass('selected');
            var type = 'block';
            if(target.hasClass('button'))
                type = 'button';
            propertiesTarget = {
                target: target,
                type: type,
                colour: target.attr('data-colour')
            };
            updateProperties();
            if(!wideMode)
                chooseTab('properties');
        });
        function validateTarget() {
            return propertiesTarget != null && propertiesTarget.target.hasClass('hyperblock');
        }

        // Properties
        function updateProperties() {
            if(!validateTarget())
                return;
            clearProperties();
            addProperty('colour', null, null);
            if(propertiesTarget.target.hasClass('heading'))
                addProperty('input', '.heading', 'Heading:');
            if(propertiesTarget.target.hasClass('text'))
                addProperty('textarea', '.text', 'Text:');
            if(propertiesTarget.type == 'button') {
                addProperty('input', '.button', 'Button text:');
                addProperty('input', '.button:href', 'Button link:');
                addProperty('input', '.button:title', 'Button tooltip:');
            }
            addProperty('remove', null, null);
        }
        function addProperty(type, arg1, arg2) {
            var htmlToAppend = '';
            var typeName = 'HyperBlock';
            if(propertiesTarget.type == 'button')
                typeName = 'HyperButton';
            if(type == 'colour') {
                htmlToAppend = '<div id="colour-picker" class="property">';
                htmlToAppend += '<div class="title">Pick a colour for this ' + typeName + ':</div>';
                htmlToAppend += '<div class="options">';
                if(propertiesTarget.type != 'button')
                    htmlToAppend += '<span class="transparent" title="Transparent"></span>';
                for (var name in hbColours) {
                    htmlToAppend += '<span class="' + name + '" title="' + name.charAt(0).toUpperCase() + name.slice(1) + '"></span>';
                }
                htmlToAppend +='</div>' +
                    '</div>';
                $('#properties').append(htmlToAppend);
            }
            if(type == 'input') {
                htmlToAppend += '<div class="property input">';
                htmlToAppend += '<div class="title">' + arg2 + '</div>';
                var targets = arg1.split(':');
                if(targets.length == 1)
                    htmlToAppend += '<div class="input"><input class="changeable" type="text" data-target="' + targets[0] + '" value="' + propertiesTarget.target.find(targets[0] + '-markdown').text() + '"></div>';
                else {
                    htmlToAppend += '<div class="input"><input class="changeable" type="text" data-target="' + targets[0] + '" data-targetattr="' + targets[1] + '" value="' + propertiesTarget.target.find(targets[0]).attr(targets[1]) + '"></div>';
                }
                htmlToAppend += '</div>';
                $('#properties').append(htmlToAppend);
            }
            if(type == 'textarea') {
                htmlToAppend += '<div class="property text">';
                htmlToAppend += '<div class="title">' + arg2 + '</div>';
                var targets = arg1.split(':');
                if(targets.length == 1)
                    htmlToAppend += '<div class="textarea"><textarea class="changeable" data-target="' + targets[0] + '">' + propertiesTarget.target.find(targets[0] + '-markdown').text() + '</textarea></div>';
                else {
                    htmlToAppend += '<div class="textarea"><textarea class="changeable" data-target="' + targets[0] + '" data-targetattr="' + targets[1] + '">' + propertiesTarget.target.find(targets[0]).attr(targets[1]) + '</textarea></div>';
                }
                htmlToAppend += '</div>';
                $('#properties').append(htmlToAppend);
            }
            if(type == 'remove') {
                $('#properties').append('<a id="remove-hyperblock" href="#remove-hyperblock">Remove this ' + typeName + '</a>');
            }
        }
        function clearProperties() {
            $('#properties').html('');
        }

        // Properties watchers
        body.on('click', '#clear-sidebar', function(e) {
            e.preventDefault();
            if(confirm('This will delete all HyperBlocks. Do you want to continue?')) {
                $('#sidebar-md').html('');
                clearProperties();
                hbExport('cookie');
            }
        });
        body.on('click', '#colour-picker .options span', function() {
            var colour = $(this).attr('class');
            if(colour == null || !validateTarget())
                return;
            if(propertiesTarget.type == 'button')
                propertiesTarget.target.find('.button').attr('data-colour', colour);
            else
                propertiesTarget.target.attr('data-colour', colour);
            hbExport('cookie');
        });
        body.on('keyup', '.property .changeable', function() {
            if(!validateTarget())
                return;
            if($(this).data('targetattr') == null) {
                propertiesTarget.target.find($(this).data('target') + '-markdown').text($(this).val());
                propertiesTarget.target.find($(this).data('target')).html(marked($(this).val()));
            } else
                propertiesTarget.target.find($(this).data('target')).attr($(this).data('targetattr'), $(this).val());
            hbExport('cookie');
        });
        body.on('click', '#remove-hyperblock', function(e) {
            e.preventDefault();
            if(!validateTarget())
                return;
            if(confirm('Are you sure you want to delete this HyperBlock? This action cannot be undone.')) {
                propertiesTarget.target.remove();
                propertiesTarget = null;
                clearProperties();
                hbExport('cookie');
            }
        });

        // Icons
        $.fn.extend({
            insertAtCaret: function(myValue) {
                if (document.selection) {
                    this.focus();
                    sel = document.selection.createRange();
                    sel.text = myValue;
                    this.focus();
                }
                else if (this.selectionStart || this.selectionStart == '0') {
                    var startPos = this.selectionStart;
                    var endPos = this.selectionEnd;
                    var scrollTop = this.scrollTop;
                    this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                    this.focus();
                    this.selectionStart = startPos + myValue.length;
                    this.selectionEnd = startPos + myValue.length;
                    this.scrollTop = scrollTop;
                } else {
                    this.value += myValue;
                    this.focus();
                }
            }
        })

        // Links
        body.on('click', '.scroll > a', function(e) {
            e.preventDefault();
        });

        body.on('click', '.hyperblock > a', function(e) {
            e.preventDefault();
        });
    </script>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-58505522-2', 'auto');
        ga('send', 'pageview');
    </script>

</body>

</html>