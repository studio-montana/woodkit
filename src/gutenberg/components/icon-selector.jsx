import { __ } from '@wordpress/i18n'
const { Component } = wp.element
const { Button, TextControl } = wp.components
const { compose } = wp.compose
const { withSelect } = wp.data

class WKG_Icon_Selector extends Component {

	constructor (props) {
    super(props)
		this.state = {
			value: this.props.value,
			options: this.props.options,
			open_selector: false,
			filter_label: '',
		}
  }

	async onChange (value) {
		if (this.props.close_after_change !== false) {
			await this.setState({value, open_selector: false})
		} else {
			await this.setState({value})
		}
		if (this.props.onChange) {
			this.props.onChange(this.state.value)
		} else {
			console.warn('WKG_Icon_Selector doit recevoir la propriété \'onChange={value => {}}}\'')
		}
	}

	render_ctrl () {
		if (!this.state.open_selector) {
			return (
				<div style={{display: 'flex', justifyContent: 'space-between'}}>
					<Button className="wkg-btn light" onClick={() => this.setState({open_selector: true})}>Choisir l'icône</Button>
					<Button className="wkg-btn light" style={{marginLeft: '6px'}} onClick={() => this.onChange(null)}>[DEL]</Button>
				</div>
			)
		}
		return null
	}

	render_icon () {
		if (this.state.value) {
			return (
				<div style={styles.icon_render_wrapper}>
					<i className={this.state.value} style={styles.icon_render} />
				</div>
			)
		}
		return null
	}

	render_selector () {
		if (this.state.open_selector) {
			let options = []
			if (this.props.removeDefaultIconsSet && this.props.iconsSet) {
				options = this.props.iconsSet
			} else {
				let default_icons_set = this.props.default_icons ? this.props.default_icons : []
				if (this.props.iconsSet) {
					options = this.props.iconsSet.concat(default_icons_set)
				} else {
					options = default_icons_set
				}
			}
			let icons = []
			for (var icons_set of options) {
				icons.push(this.render_icons_set(icons_set.title, icons_set.icons))
			}
			return (
				<div style={{border: '1px solid #eeeeee', backgroundColor: '#ffffff'}}>
					<div style={{padding: '6px 12px', borderBottom: '1px solid #eeeeee', backgroundColor: '#fcfcfc', display: 'flex', alignItems: 'center'}}>
						<div>
							<TextControl placeholder="Recherche..." value={this.state.filter_label} onChange={(filter_label) => this.setState({filter_label})} />
						</div>
						<div style={{padding: '0 6px', textAlign: 'center', cursor: 'pointer'}} onClick={() => this.setState({open_selector: false})}>Fermer</div>
					</div>
					<div style={{padding: '12px', height: '400px', overflow: 'scroll'}}>
						{icons}
					</div>
				</div>
			)
		}
		return null
	}

	render_icons_set (set_title, icons_set) {
		let icons = []
		for (var icon of icons_set) {
			if (!this.state.filter_label || icon.label.includes(this.state.filter_label)) {
				let selected = false
				if (this.state.value === icon.value) {
					selected = true
				}
				icons.push((
					<WKG_Icon_Selector_Item selected={selected} value={icon.value} label={icon.label} onClick={value => this.onChange(value)} />
				))
			}
		}
		if (icons.length > 0) {
			return (
				<div>
					<h3>{set_title}</h3>
					<div style={{display: 'flex', flexWrap: 'wrap'}}>
						{icons}
					</div>
				</div>
			)
		}
		return null
	}

	render () {
		return (
			<div style={styles.selector}>
				{this.render_icon()}
				{this.render_selector()}
				{this.render_ctrl()}
			</div>
    )
  }
}

export default compose(withSelect((select, props) => {
		const default_icons = select('wkg/commons').getIcons(props.families)
	  return { default_icons }
	}))(WKG_Icon_Selector)

class WKG_Icon_Selector_Item extends Component {
	render () {
		let item_styles = styles.icon_item
		if (this.props.selected) {
			item_styles = {...item_styles, ...styles.icon_item_selected}
		}
		return (
			<div onClick={() => this.props.onClick(this.props.value)} style={item_styles}><i className={this.props.value}></i></div>
    )
  }
}

const styles = {
	selector: {
		width: '100%',
    position: 'relative',
	},
	icon_render_wrapper: {
		textAlign: 'center',
	},
	icon_render: {
		fontSize: '60px',
		display: 'block',
    height: 'auto',
    width: 'auto',
		padding: '6px',
	},
	icon_item: {
		width: '31px',
		margin: '6px',
		padding: '3px',
		cursor: 'pointer',
		border: '2px solid #ffffff',
		textAlign: 'center',
	},
	icon_item_selected: {
		border: '2px solid #007cba',
	}
}
