const { Component } = wp.element
const { apiFetch } = wp
const { Icon } = wp.components

export default class WKG_Media extends Component {

	constructor (props) {
    super(props)
    this.state = {
      media: null,
    }
  }

	componentDidMount () {
		this.loadMedia()
	}

	loadMedia() {
    if (this.props.attachment) {
			apiFetch({ path: '/wp/v2/media/' + parseInt(this.props.attachment) }).then(res => {
				this.setState({media : res})
			})
    } else {
      console.warn('Le composant WKG_Media doit recevoir l\'attribut \'attachment\'');
    }
  }

	render () {
    if (this.state.media) {
      if (this.state.media.media_type === 'image') {
        let url = ''
        if (this.props.size && this.state.media.media_details && this.state.media.media_details.sizes && this.state.media.media_details.sizes[this.props.size]) {
          url = this.state.media.media_details.sizes[this.props.size].source_url
        } else if (this.state.media.media_details && this.state.media.media_details.sizes && this.state.media.media_details.sizes.thumbnail) {
          url = this.state.media.media_details.sizes.thumbnail.source_url
        } else {
					url = this.state.media.source_url
				}
        let title = ''
        if (this.state.media.title) {
          title = this.state.media.title.rendered
        }
        return (
          <img style={{...styles.img, ...this.props.style}} src={url} alt={title} />
        )
      } else if (this.state.media.media_type === 'file') {
				let icon = null
				if (this.state.media.mime_type === 'application/pdf') {
					icon = <Icon icon="media-document" size={50} />
				} else {
					icon = <Icon icon="media-default" size={50} />
				}
				return (
					<div style={styles.file}>
						<div style={styles.file_icon}>{icon}</div>
						<div style={styles.file_title}>{this.state.media.title ? this.state.media.title.rendered : 'sans titre'}</div>
					</div>
				)
			}
      return (
        <div style={styles.warning}>Media type not supported</div>
      )
    }
    return (
      <div style={{...styles.loading, ...this.props.styleLoading}}>Loading...</div>
    )
  }
}

const styles = {
  img: {
    display: 'inline-block',
  },
  loading: {
    color: '#999999',
  },
  file: {
		margin: '6px 0',
		padding: '6px',
		border: '1px solid #eeeeee',
	},
  warning: {
    color: '#999999',
  },
	file_icon: {},
	file_title: {
		fontSize: '10px',
	},
}
