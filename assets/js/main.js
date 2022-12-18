jQuery( function( $ ) {

    /*
    * CFFE
    *
    * Main flex edit core
    * */
    class CFFE {

        /**
        * Create initial variables and run the desired methods
        * */
        constructor() {

            /*
             * Iportant selectors
             *
             * It was created to be convenient to refer to the selectors,
             * but in fact turned out to be a bad idea
             *
             * todo do not store selectors in variables
             * */
            this.adminElementTeplateID      = 'admin-controls'
            this.tabHeadSetiingSelector     = '.cfc-panel__tab-head.content'
            this.tabHeadWidgetSelector      = '.cfc-panel__tab-head.widgets'
            this.backToWidgetsSelector      = '.cfc-panel__tab-head.content .back'
            this.tabHeadSettingNameSelector = '.cfc-panel__tab-head.content span'
            this.controlselector            = '.cfc-control'
            this.cfcfieldClassName          = 'cfc-field'
            this.cfcfieldContentClassName   = 'cfc-field-content'
            this.cfcPanelClassName          = 'cfc-panel'
            this.deleteWidgetSelector       = '.admin-controls .delete'
            this.flexContainerSelector      = '.flex-container'

            /*
             * Containers
             * */
            this.elContainer    = document.querySelector('#cfc-container')
            this.elWidgets      = document.querySelector('#cfc-widgets')
            this.elSettings     = document.querySelector('#cfc-settings')

            //template for admin controls
            this.adminElementTemplate = document.getElementById( this.adminElementTeplateID).content

            //Widgets settings
            const widgetSettingsArea = document.querySelector('#cfc-widgets-settings').value
            this.widgetsSettings     = widgetSettingsArea ? JSON.parse( widgetSettingsArea ) : {}
            this.widgetContext       = {}

            //Flags
            this.isSettingsSectionOpen = false
            this.isDrag                = false
            this.isEdit                = false

            this.init()
            this.actions()
        }

        /**
         * Init
         * */
        init() {
            const
                _this = this,
                containers = this.makeContainersDragable(false)

            _this.maybeContainerEmpty()

            this.drake = dragula(containers, {
                copy: function (el, source) {
                    return source.classList.contains('cfc-panel__tab__widgets')
                },
                accepts: function (el, target) {
                    return !target.classList.contains('cfc-panel__tab__widgets')
                },
                revertOnSpill: true
            })
        }

        /**
         * Actions
         * */
        actions() {
            const _this = this;

            //set drag-n-drop settings
            this.drake
                .on('drop', function (el, target, source, sibling) {
                    _this.insertWidget(el, target, source, sibling)
                    _this.saveCode()
                    _this.maybeContainerEmpty()
                })
                .on('drag', function (el, source) {
                    _this.isDrag = true

                    if ( source === _this.elWidgets ) return
                    _this.elContainer.classList.add('movement')
                })
                .on('dragend', function (el) {
                    _this.isDrag = false
                    _this.elContainer.classList.remove('movement')
                })

            $(document)
                //back to all widgets
                .on('click', this.backToWidgetsSelector, function () {
                    _this.showWidgets()
                })

                //set setting from controller
                .on('keyup change', '.cfc-control', function (e) {
                    let val = this.value;

                    if (this.type ==='checkbox') {
                        val = this.checked ? val : ''
                    }

                    _this.changeState(this.dataset.settingId,val)
                })

                .on('focusin', '.cfc-control', function (e) {
                    _this.isEdit = this
                })

                .on('focusout', '.cfc-control', function (e) {
                    _this.isEdit = false
                })

                //if click was on not settings container
                .on('click', function (e) {
                    _this.maybeCloseSettings(e)
                })

                //show and set settings to widget
                .on('click', '.' + this.cfcfieldClassName, function (e) {
                    e.stopPropagation()
                    if ( _this.isDrag ) return

                    if ( _this.isEdit !== false) {
                        switch (_this.isEdit) {
                            case 'WYSIWYG':
                                tinymce.get('cfcwysiwyg').execCommand('mceBlur')
                                break;

                            default:
                                _this.isEdit.blur()
                                break
                        }
                    }

                    const
                        widgetId    = this.dataset.cfcWidgetId,
                        widgetName  = this.dataset.cfcTemplateName

                    _this.setWidgetContext(widgetId, widgetName)
                    _this.showSettings()
                })

                //delete widget
                .on('click', this.deleteWidgetSelector, function (e) {
                    e.stopPropagation()
                    e.preventDefault()
                    _this.removeWidgets(this)
                    _this.showWidgets()
                })
        }

        /*
        * Insert widget after drop
        * */
        insertWidget(el, target, source, siblings) {
            const _this = this;

            if ( source.classList.contains('cfc-panel__tab__widgets') ) {
                //delete current placeholder
                el.remove()

                var widgetName              = el.dataset.widgetName,
                    adminElements           = this.getAdminControls(),
                    renderWidget            = document.createElement('div'),
                    widgetWrap              = document.createElement("div"),
                    widgetId               = this.makeid(5);

                this.setWidgetContext(widgetId, widgetName)
                this.createWidgetSettings()

                const template = this.renderTemplate()

                //admin template widget
                renderWidget.classList.add(this.cfcfieldContentClassName)
                renderWidget.innerHTML = template;

                //admin wrap of widget
                widgetWrap.classList.add(this.cfcfieldClassName )
                widgetWrap.classList.add(this.cfcfieldClassName + '-'+ widgetName)
                widgetWrap.dataset.cfcWidgetId = widgetId
                widgetWrap.dataset.cfcTemplateName = widgetName
                widgetWrap.appendChild(adminElements)
                widgetWrap.appendChild(renderWidget)

                //if widget is container make him draggable
                if ( widgetName === 'flex-container' ) {
                    this.drake.containers.push(widgetWrap.querySelector('.flex-container'))
                }

                if ( siblings ) {
                    target.insertBefore(widgetWrap, siblings)
                } else {
                    target.appendChild(widgetWrap)
                }

                this.showSettings()
                this.saveCode()
            }
        }

        /*
        * Get admin controls template
        * */
        getAdminControls() {
            const
                adminElementsTemplate   = this.adminElementTemplate,
                adminElements           = document.importNode(adminElementsTemplate, true)

            return adminElements;
        }

        /*
        * Set current widget context
        * on this context will be based on the rest of the methods
        * */
        setWidgetContext(widgetId, widgetName) {
            this.widgetContext = {widgetId, widgetName}
        }

        /*
        * Render settings on setting panel
        * */
        renderSettings() {
            const
                currentId = this.widgetContext.widgetId,
                currentName = this.widgetContext.widgetName,
                widgetData = CFCWidgetsData[ currentName ],
                widgetSettings = this.getWidgetSettings(currentId)

            //show title of current widget
            $(this.tabHeadSettingNameSelector).text(widgetData.title)

            //render elements
            this.elSettings.innerHTML = ''

            var controls = document.createElement('div');
            controls.innerHTML = widgetData.controls;

            //set settings
            controls.querySelectorAll( this.controlselector ).forEach( (el, i) => {
                const settingName = el.dataset.settingId

                if ( widgetSettings[settingName] ) {
                    switch (el.type) {
                        case 'radio':
                            if (el.value === widgetSettings[settingName]) {
                                el.checked = true
                            }
                            break;

                        case 'checkbox':
                            if ( widgetSettings[settingName] !== '' ) {
                                el.checked = true
                            } else {
                                el.checked = false
                            }
                            break;

                        default:
                            el.value = widgetSettings[settingName]
                            break

                    }
                }
            })

            this.elSettings.appendChild(controls)
        }

        /*
        * Create widget settings with default values
        * */
        createWidgetSettings() {
            let controlsList = CFCWidgetsData[this.widgetContext.widgetName].controls_default
            this.widgetsSettings[this.widgetContext.widgetId] = {}

            for (var key in controlsList) {
                this.widgetsSettings[this.widgetContext.widgetId][key] = controlsList[key]
            }

            this.saveSettings()
        }

        /*
        * Update widget settings
        * */
        updateSetting( settingId, newVal ) {
            this.widgetsSettings[this.widgetContext.widgetId][settingId] = newVal
            this.saveSettings()
        }

        /*
        * Make all .flex-container dragable
        * 1. setup admin controls if form exist
        * 2. set (if is init) or return containers to drag
        * */
        makeContainersDragable(set = true) {
            //if form exist add admin controls
            const fields = document.querySelectorAll('.cfc-field'),
                containers = [this.elContainer]

            document.querySelectorAll('.cfc-panel__tab__widgets').forEach((el, i) => {
                containers.push(el)
            })

            if ( fields.length ) {
                if ( ! set ) {
                    $('.cfc-field').prepend(this.getAdminControls())
                }

                fields.forEach( (el, i) => {
                    if ( el.dataset.cfcTemplateName === 'flex-container' ) {
                        containers.push(el.querySelector('.flex-container'))
                    }
                } )
            }

            if ( set ) {
                this.drake.containers = containers
            } else {
                return containers;
            }

        }

        /*
        * Update widget with new data
        * */
        renderWidget() {
            let currentID     = this.widgetContext.widgetId,
                selector        = '.' + this.cfcfieldClassName + '[data-cfc-widget-id='+ currentID +'] .' + this.cfcfieldContentClassName,
                currentWidget   = document.querySelector(selector),
                innerContent    = '';

            if ( this.widgetContext.widgetName === 'flex-container') {
                innerContent = currentWidget.querySelector('.flex-container').innerHTML
            }

            currentWidget.innerHTML = this.renderTemplate(innerContent)

            this.maybeContainerEmpty()
            this.saveSettings()
            this.saveCode()
        }

        /*
        * render template
        *
        * if innerContent set, that mean is .flex-container
        * */
        renderTemplate( innerContent ) {
            let
                widgetName  = this.widgetContext.widgetName,
                template    = this.getWidgetTemplate(widgetName),
                widgetId    = this.widgetContext.widgetId,
                _this       = this

            template = template.replaceAll(/{{(\w+)}}/g, function (el, settingName, pos) {
                let content = _this.getWidgetSettings(widgetId)[settingName]

                // if ( widgetName === 'cfc-code' && settingName === 'code' ) {
                //     content = escapeHtml(content)
                // }

                return content
            })

            //It is assumed that we are dealing only with a container
            if ( innerContent ) {
                template = template.replace('><', '>' + innerContent +'<')
            }

            return template
        }

        /*
        * Close the settings window when clicking past
        * */
        maybeCloseSettings(e) {
            var panel   = $('.' + this.cfcPanelClassName ),
                field   = $('.' + this.cfcfieldClassName ),
                mce     = $('.mce-container-body.mce-stack-layout'),
                mediaInsert = $('.media-button-insert')

            if (
                panel.has(e.target).length === 0 &&
                this.isSettingsSectionOpen && ! field.has(e.target).length
                && ! $('body').hasClass('modal-open')
                && mce.has(e.target) === 0
                && mediaInsert.has(e.target) === 0
            ){
                this.showWidgets()
            }
        }

        // Remove context
        removeContext() {
            this.widgetContext = {}
        }

        /*
        * Remove widgets
        * */
        removeWidgets(el) {
            let field = $(el).parents( '.' + this.cfcfieldClassName)[0],
                childrenFields = $(field).find('.' + this.cfcfieldClassName),
                _this = this


            if ( childrenFields.length ) {
                $(childrenFields).each(function (i, chField) {
                    _this.removeWidget(chField)
                })
            }

            this.removeWidget(field)
            this.saveCode()
            this.saveSettings()
            this.maybeContainerEmpty()
        }

        /*
        * remove widget
        * */
        removeWidget( field ) {
            const
                widgetID    = field.dataset.cfcWidgetId,
                template    = field.dataset.cfcTemplateName

            if ( template === 'flex-container') {
                this.drake.containers.forEach( (item, i) => {
                    let widgetContent = field.querySelector('.flex-container')

                    if (item === widgetContent) {
                        this.drake.containers.splice(i, 1)
                    }
                })
            }

            field.remove()
            delete this.widgetsSettings[widgetID]
        }

        /*
        * Get setting of widget
        * */
        getWidgetSettings(widgetId) {
            return this.widgetsSettings[widgetId];
        }

        /*
        * Get clear(without admin controls) widget template
        * */
        getWidgetTemplate(widgetName) {
            return CFCWidgetsData[widgetName].template;
        }

        /*
        * Make active window of widget list
        * */
        showWidgets() {
            $(this.tabHeadSetiingSelector).removeClass('active')
            $(this.tabHeadWidgetSelector).addClass('active')

            $(this.elSettings).hide()
            $(this.elWidgets).show()

            this.isSettingsSectionOpen = false
        }

        /*
        * Make active window setting
        * */
        showSettings() {
            if ( typeof tinymce !== 'undefined') {
                wp.editor.remove('cfcwysiwyg')
            }

            $(this.tabHeadWidgetSelector).removeClass('active')
            $(this.tabHeadSetiingSelector).addClass('active')

            $(this.elWidgets).hide()
            $(this.elSettings).show()

            this.isSettingsSectionOpen = true

            this.renderSettings()
            this.maybeUpdateCustom()
        }

        /*
        * save settings
        * */
        saveSettings() {
            $('#cfc-widgets-settings').val(JSON.stringify(this.widgetsSettings, null, '\t'))
        }

        /*
        * save code
        * */
        saveCode() {
            //timeout because .gu-transit className not removed
            setTimeout(() => {
                let
                    contents = this.elContainer.cloneNode(true),
                    adminControls = contents.querySelectorAll('.admin-controls'),
                    //fix
                    gutransit = contents.querySelectorAll('.gu-transit')

                adminControls.forEach((el, i) => {
                    el.remove()
                })

                gutransit.forEach((el, i) => {
                    el.classList.remove('.gu-transit')
                })

                $('#wpcf7-form').val(contents.innerHTML.replaceAll(/\s\s/g, ' '))
            }, 10)
        }

        /*
        * Make unique widget id
        * */
        makeid(length) {
            var result           = '';
            var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            var charactersLength = characters.length;
            for ( var i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }

            //if id is exist try create again
            if ( this.widgetsSettings[result] ) {
                this.makeid(length)
            }

            return result;
        }

        /*
        * If container empty
        * */
        maybeContainerEmpty() {
            // const containers =
           setTimeout(() => {
               document.querySelectorAll('.flex-container').forEach((el, i) => {
                   if ( el.querySelector('.' + this.cfcfieldClassName ) ) {
                       el.classList.remove('empty')
                   } else {
                       el.classList.add('empty')
                   }
               }, 100)
           })
        }

        /*
        * if need update custom update widget setting
        * */
        maybeUpdateCustom() {
            const _this = this

            //range
            const field = $('.cfc-control-field input[type=number]');
            field.each(function (i, el) {
                $(el)
                    .siblings('input[type=range]')
                    .val($(el).val())
            })

            //WYSIWYG
            if ( 'WYSIWYG' === this.widgetContext.widgetName ) {
                $('.wp-switch-editor.switch-html').trigger('click')
                $('.wp-switch-editor.switch-tmce').trigger('click')

                let text = _this.getWidgetSettings(this.widgetContext.widgetId).text
                tinymce.activeEditor.setContent(text, {format: 'html'});

                tinymce.get('cfcwysiwyg').on('keyup change', function(e) {
                    _this.changeState('text', tinymce.get('cfcwysiwyg').getContent())
                });

                tinymce.get('cfcwysiwyg').on('focusin', function(e) {
                    _this.isEdit = 'WYSIWYG'
                });

                tinymce.get('cfcwysiwyg').on('focusout', function(e) {
                    _this.isEdit = false
                });
            }

        }

        /*
        * Update widget with new data
        * */
        changeState(settingId, data) {
            this.updateSetting(settingId, data)
            this.renderWidget()
            this.makeContainersDragable()
        }
    }

    /*
    * Init class
    * */
    let cffe = new CFFE()

    /*
    * insert content from tag generator to our field
    * */
    wpcf7.taggen.insert = function ( content ) {
        $('[data-setting-id=tag_content]')
            .val(content)
            .trigger('change')
    }

    /*
    * Range additional
    * */
    let is_click_range = false;

    $(document).on('mousedown', '.cfc-control-field input[type=range]', function () {
        is_click_range = true
    })

    $(document).on('mousemove', '.cfc-control-field input[type=range]', function () {
        if ( is_click_range ) {
            $(this)
                .siblings('input[type=number]')
                .val(this.value)
                .trigger('change')
        }
    })

    $(document).on('mouseup', '.cfc-control-field input[type=range]', function () {
        is_click_range = false
    })

    $(document).on('change', '.cfc-control-field input[type=range]', function () {
        $(this)
            .siblings('input[type=number]')
            .val(this.value)
            .trigger('change')
    })

    $(document).on('keyup change', '.cfc-control-field input[type=number]', function () {
        $(this)
            .siblings('input[type=range]')
            .val(this.value)
    })


    /*
    * custom resize setting window
    * */
    let
        is_clicked_mover = false,
        init_pos         = 0,
        panelWidth       = 300;

    $(document).on('mousedown', '.cfc-panel__mover', function (e) {
        is_clicked_mover = true
        init_pos = e.clientX
    })

    $(document).on('mousemove', function (e) {
        if ( is_clicked_mover ) {
            let delta = init_pos - e.clientX,
                pos = panelWidth + delta;

            $('.cfc').css('grid-template-columns', '1fr ' + pos + 'px')
        }
    })

    $(document).on('mouseup', function (e) {
        if (is_clicked_mover) {
            is_clicked_mover = false
            panelWidth = (init_pos - e.clientX) + panelWidth
            init_pos = 0
        }
    })

    //checkbox better
    $(document).on('click', '.cfc-control-field.checkbox', function (e) {
        // $(this).siblings('.cfc-control__content').find('input[type=checkbox]')
    })

    /*
    * Function like esc_html() php
    * */
    function escapeHtml(text) {
        var map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };

        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }

    /*
    * Function for decode html special charts
    * */
    function decodeHtml(text) {
        var map = {
            '&amp;': '&',
            '&lt;': '<',
            '&gt;':'>' ,
            '&quot;': '"',
            '&#039;':"'"
        };

        return text.replace(/&amp;|&lt;|&gt;|&quot;|&#039;/g, function(m) { return map[m]; });
    }

    /*
    * Editor tabs
    * */
    $('.cfc-wrapper-tabs__title').on('click', function (e) {
        const index = $(this).index()

        $('.cfc-wrapper-tabs__title').removeClass('active')
        $(this).addClass('active')

        $('.cfc-wrapper-tabs__content')
            .hide()
            .eq(index).show()
    })
});
































