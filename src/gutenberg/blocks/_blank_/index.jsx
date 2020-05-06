const { registerBlockType } = wp.blocks
const { Component } = wp.element

registerBlockType('wkg/_blank_', {
	title: 'WKG _blank_',
	category: 'common',
	supports: {
		html: false,
		reusable: false,
	},
	attributes: {
		id: {
			type: 'string',
		},
	},
	edit: function (props) {
		// console.log('attributes : ', props.attributes)
		props.attributes.id = 'wkg' + props.clientId
		props.className += " wkg-editor wkg-item"
		return (
			<div className={props.className}>
				<h3 className="wkg-title">
					Titre du block
					<span className="wkg-info">(Pour configurer ce bloc, vous devez cliquer dessus puis utiliser le panneau de configuration en colonne de droite de l'éditeur)</span>
				</h3>
				<BlockComponent
					attributes={props.attributes}
					isSelected={props.isSelected}
					onChange={attributes => props.setAttributes(attributes)}
				/>
			</div>
		)
	},
	save: function () {
		// return null, this front render is managed by PHP - this is a dynamic block
		return null;
	}
})

class BlockComponent extends Component {
	constructor(props) {
		super(props)
		this.state = {...this.props.attributes, ...{
			// block specifics state attributes
		}}
	}
	onChange (obj) {
		this.setState(obj)
		this.props.onChange(obj)
	}
	render () {
		return (
			<div>
				<div className="wkg-content">
					TODO display block admin content
				</div>
				<InspectorControls>
						<PanelBody title="Configuration" initialOpen={ true }>
							<PanelRow>
								TODO block configuration
							</PanelRow>
						</PanelBody>
				</InspectorControls>
			</div>
		)
	}
}

const styles = {}
