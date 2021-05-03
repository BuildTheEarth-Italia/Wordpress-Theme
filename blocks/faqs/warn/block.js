//  Import CSS.
import './style.scss';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { useBlockProps, RichText } = wp.blockEditor;
const { Dashicon } = wp.components;

registerBlockType( 'bte/faqs-warn', {
	title: __( 'Alert' ),
	icon: 'warning',
	category: 'widgets',
	attributes: {
		content: {
			type: 'string',
			source: 'text',
			selector: 'p',
		}
	},

	edit: ( {attributes, setAttributes} ) => {
		const blockProps = useBlockProps();
		
		return (
			<div className="warn-block">
				<Dashicon icon="warning" className="warn-icon" />
				<RichText
					{ ...blockProps }
					tagName="p"
					value={ attributes.content }
					allowedFormats={ [ 'core/bold', 'core/italic' ] } 
					onChange={ ( content ) => setAttributes( { content } ) }
					className="warn-content"
				/>
			</div>
		);
	},

	save: ( { attributes } ) => {		
		const blockProps = useBlockProps.save();
		return (
			<div className="warn-block">
				<Dashicon icon="warning" className="warn-icon" />
				<RichText.Content
					{ ...blockProps }
					tagName="p"
					value={ attributes.content }
					className="warn-content"
				/>
			</div>
		);
	},
});
