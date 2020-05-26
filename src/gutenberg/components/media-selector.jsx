import { __ } from '@wordpress/i18n'
const { Component } = wp.element
const { apiFetch } = wp
const { Button, SelectControl, Placeholder } = wp.components
const { MediaUpload } = wp.blockEditor
import WKG_Media from './media.jsx'

export default class WKG_Media_Selector extends Component {

	constructor (props) {
    super(props)
		this.state = {
			id: this.props.value && this.props.value.id ? parseInt(this.props.value.id) : this.props.value,
			size: this.props.value && this.props.value.size ? this.props.value.size : (this.props.defaultSize || 'thumbnail'),
			url: this.props.value && this.props.value.url ? this.props.value.url : '',
			media: null,
			ready: false,
			defaultSize: this.props.defaultSize ? this.props.defaultSize : 'thumbnail'
		}
  }

	async componentDidMount () {
		// s'il n'y a qu'une taille de définie, on la fixe au state car elle ne peut pas être autre.
		// Dans ce cas, le sélecteur de taille n'apparaitra pas pour ne pas surcharger inutiliement l'interface de ce choix unique
		if (this.props.available_sizes && this.props.available_sizes.length === 1) {
			await this.setState({size: this.props.available_sizes[0].value})
		}
		// on charge le media s'il est passé en props
		if (this.state.id) {
			this.setMedia(this.state.id, this.state.size, true)
		} else {
			this.setState({ready: true})
		}
	}

	async setMedia (arg_media_id, arg_size, preventFire) {
		let size = arg_size || this.state.size
		let id = arg_media_id || this.state.id
		await this.setState({ready: false})
		// load media
		if (id && Number.isInteger(id)) {
			apiFetch({ path: '/wp/v2/media/' + parseInt(id) }).then(res => {
				console.log('Media : ', res)
				this.setState({ready: true, media: res, id, url: this.getMediaUrlForSize(res, size), size})
				if (!preventFire) {
					this.onChange()
				}
			})
		} else {
			// set size at least
			await this.setState({ready: true, media: null, id: null, url: null, size})
			if (!preventFire) {
				this.onChange()
			}
		}
	}

	getMediaUrlForSize (media, size) {
		let url = ''
		if (size && size !== '' && media && media.media_details.sizes && media.media_details.sizes[size]) {
			url = media.media_details.sizes[size].source_url
		}
		if (url === '' && this.state.defaultSize && this.state.defaultSize !== '' && media && media.media_details.sizes && media.media_details.sizes[this.state.defaultSize]) {
			url = media.media_details.sizes[this.state.defaultSize].source_url
		}
		if (url === '') {
			url = media.source_url
		}
		return url
	}

	async removeMedia (preventFire) {
		await this.setState({media: null, id: null, url: null})
		if (!preventFire) {
			this.onChange()
		}
	}

	onChange () {
		if (this.props.onChange) {
			this.props.onChange({id: this.state.id, size: this.state.size, url: this.state.url})
		} else {
			console.warn('WKG_Media_Selector doit recevoir la propriété \'onChange={(media) => {}}}\'')
		}
	}

	render_open (open) {
		if (this.state.id) {
			return (
				<Button className="wkg-btn light" onClick={open}>{this.props.label_button_update ? this.props.label_button_update : 'Modifier'}</Button>
			)
		}
		return <Button className="wkg-btn light" onClick={open}>{this.props.label_button ? this.props.label_button : 'Choisir l\'image'}</Button>
	}

	render_media () {
		if (this.props.show && this.state.id) {
			let showsize = this.props.showsize || 'medium'
			let media_style = {...{width: '100%', height: 'auto'}, ...this.props.styleMedia}
			return (
				<div className="media_render">
					<WKG_Media attachment={this.state.id} size={showsize} style={media_style} />
				</div>
			)
		}
		return null
	}

	render_remove () {
		if (this.state.id) {
			return (
				<Button className="wkg-btn icon light" style={{marginLeft: '6px'}} onClick={() => this.removeMedia()}>[DEL]</Button>
			)
		}
		return null
	}

	render_size_control () {
		// uniquement pour les images
		if (this.state.media && this.state.media.media_type === 'image') {
			let size_controler = null
			let size_options = this.props.available_sizes
			if (!size_options) { // defaults
				size_options = [
					{value: 'thumbnail', 	label: 'thumbnail'},
					{value: 'small', 			label: 'small'},
					{value: 'medium', 		label: 'medium'},
					{value: 'large', 			label: 'large'},
				]
			}
			if (size_options && size_options.length > 1) {
				return (
					<div style={styles.size_controler}>
							<SelectControl
								options={size_options}
								onChange={size => this.setMedia(null, size)}
								value={this.state.size}
							/>
					</div>
				)
			}
		}
		return null
	}

	render () {
		if (!this.state.ready) {
			return (
				<div style={styles.loading}>Loading</div>
			)
		}
		let render_label = null
		if (this.props.label) {
			render_label = <div className="label" style={styles.label}><label>{this.props.label}</label></div>
		}
  	return (
			<div style={styles.selector}>
				{render_label}
				{this.render_media()}
				<div style={styles.controler}>
	        <MediaUpload
						allowedTypes={this.props.allowedTypes}
						value={this.state.id}
	          onSelect={media => this.setMedia(media.id)}
	          render={({open}) => this.render_open(open)}
	        />
					{this.render_remove()}
				</div>
				{this.render_size_control()}
			</div>
    )
  }
}

const styles = {
	selector: {
		width: '100%',
		height: '100%',
    position: 'relative',
	},
	controler: {
		display: 'flex',
		justifyContent: 'space-between',
	},
	size_controler: {
		marginTop: '6px',
	},
	label: {
		marginBottom: '3px',
	},
	loading: {
		fontSize: '12px',
		color: '#999999',
	}
}
