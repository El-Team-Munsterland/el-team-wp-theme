(function (wp) {
    'use strict';
    var el = wp.element.createElement;
    var registerBlockType = wp.blocks.registerBlockType;
    var InspectorControls = wp.blockEditor.InspectorControls;
    var PanelBody = wp.components.PanelBody;
    var SelectControl = wp.components.SelectControl;
    var TextControl = wp.components.TextControl;
    var Placeholder = wp.components.Placeholder;
    var ServerSideRender = wp.serverSideRender;
    var useSelect = wp.data.useSelect;

    registerBlockType('seitenmatrix/matrix', {
        apiVersion: 2,
        title: 'Seitenmatrix',
        icon: 'editor-table',
        category: 'widgets',
        description: 'Hierarchische Unterseiten als horizontale Tabelle anzeigen.',
        attributes: {
            maxDepth: { type: 'number', default: 0 },
            style: { type: 'string', default: 'werkstatthandbuch' },
            pageId: { type: 'number', default: 0 }
        },
        edit: function (props) {
            var attrs = props.attributes;
            var currentPostId = useSelect(function (select) {
                return select('core/editor').getCurrentPostId();
            }, []);
            var previewAttrs = Object.assign({}, attrs, { pageId: currentPostId || attrs.pageId || 0 });
            return el(wp.element.Fragment, {},
                el(InspectorControls, {},
                    el(PanelBody, { title: 'Seitenmatrix-Einstellungen', initialOpen: true },
                        el(TextControl, {
                            label: 'Maximale Anzeigetiefe',
                            help: '0 = alle Ebenen; 1 = nur direkte Unterseiten; 2 = auch Unter-Unterseiten.',
                            type: 'number', min: 0, step: 1,
                            value: attrs.maxDepth,
                            onChange: function (value) {
                                props.setAttributes({ maxDepth: Math.max(0, parseInt(value, 10) || 0) });
                            }
                        }),
                        el(SelectControl, {
                            label: 'Stil', value: attrs.style,
                            options: [
                                { label: 'Werkstatthandbuch', value: 'werkstatthandbuch' },
                                { label: 'Bilder und Kurztext', value: 'bilder' }
                            ],
                            onChange: function (value) { props.setAttributes({ style: value }); }
                        })
                    )
                ),
                currentPostId ?
                    el(ServerSideRender, { block: 'seitenmatrix/matrix', attributes: previewAttrs,
                        EmptyResponsePlaceholder: function () { return el(Placeholder, {}, 'Keine veröffentlichten Unterseiten vorhanden.'); }
                    }) :
                    el(Placeholder, {}, 'Die Vorschau wird angezeigt, sobald die Seite gespeichert wurde.')
            );
        },
        save: function () { return null; }
    });
})(window.wp);
