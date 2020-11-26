/**
 * Block: Code Highlighter Block 
 */
//  Import CSS.
import './editor.scss';
import './style.scss';

import { RichText } from '@wordpress/block-editor';
import { InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl, RangeControl } from '@wordpress/components';

const { __ } = wp.i18n;
const { registerBlockType } = wp.blocks; 

const langOptions = [
	{ label: 'HTML', value: 'html' },
	{ label: 'CSS', value: 'css' },
	{ label: 'Javascript', value: 'javascript' },
	{ label: 'ASP.NET', value: 'ASP.NET' },
	{ label: 'C', value: 'c' },
	{ label: 'C++', value: 'c++' },
	{ label: 'C#', value: 'c#' },
	{ label: 'CoffeeScript', value: 'CoffeeScript' },
	{ label: 'Django', value: 'Django' },
	{ label: 'Git', value: 'git' },
	{ label: 'GraphQL', value: 'GraphQL' },
	{ label: 'Java', value: 'java' },
	{ label: 'PHP', value: 'php' },
	{ label: 'Perl', value: 'perl' },
	{ label: 'Python', value: 'python' },
	{ label: 'React JSX', value: 'ReactJSX' },
	{ label: 'Sass', value: 'Sass' },
	{ label: 'Scss', value: 'Scss' },
	{ label: 'SQL', value: 'SQL' },
];

/**
 * Block Registration 
 */
registerBlockType( 'cgb/block-code-highlighter-block', {
	title: __( 'Code Highlighter Block' ), 
	icon: 'editor-code',
	description: __( 'Highlight Code Syntax of Different Languages' ),
	category: 'common',
	keywords: [
		__( 'Code Highlighter' ),
		__( 'Code' ),
		__( 'Syntax Highlighter' ),
	],
	attributes: {
		code: {
			type: 'string'
		},
		lang: {
			type: 'string',
			default: 'php'
		},
		fontSize: {
			type: 'number',
			default: 16
		}
	},
	edit: ( { setAttributes, attributes } ) => {
		const { code,lang, fontSize } = attributes; 
		return (
			<div>
				<InspectorControls>
					<PanelBody
						title={__( "Select Language" ) }
						initialOpen={ true }
					>
						<SelectControl
							value={ lang }
							options= { langOptions }
							onChange={ ( lang ) => { setAttributes( { lang } ) } }
							formattingControls= { [ ] }
						/>
					</PanelBody>
					<PanelBody
						title={__( "Set Font Size" ) }
						initialOpen={ false }
					>
						<RangeControl
							value={ fontSize }
							onChange={ ( fontSize ) => setAttributes( { fontSize } ) }
							min={ 1 }
							max={ 50 }
						/>
					</PanelBody>
				</InspectorControls>
				<div className="cbg-block-container no-line-numbers">
					<pre data-start="1" style={{ fontSize: fontSize }}>
						<RichText
							tagName="code"
							className={`language-${lang}`}
							value={ code }
							onChange={ ( code ) => setAttributes( { code } ) }
							allowedFormats= { [] }
						/>
					</pre>
				</div>
			</div>
		);
	},
	
	save: ( { attributes } ) => {
		const { code, lang, fontSize } = attributes;
		return (
			<div className="cbg-block-container no-line-numbers">
				<pre data-start="1" style={{ fontSize: fontSize }}>
						<RichText.Content
							tagName="code"
							className={`language-${lang}`}
							value={ code }
						/>
				</pre>
			</div>
		);
	},
} );
