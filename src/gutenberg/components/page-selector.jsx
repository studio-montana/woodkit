const { Component } = wp.element
const { Button, SelectControl } = wp.components
const { compose } = wp.compose
const { withSelect, withDispatch } = wp.data

 class WKG_Page_Selector extends Component {

   constructor (props) {
     super(props)
 		this.state = {
 			selected: null
 		}
   }

 	componentDidMount () {
 		this.setState({
 			selected: this.props.value && this.props.value.id ? this.props.value.id : this.props.value
 		})
 	}

 	_onChange (value) {
 		if (this.props.onChange) {
 			this.setState({
 				selected: value
 			})
 			let pages = this.props.pages.filter(p => p.id === parseInt(value))
 			this.props.onChange(pages.length > 0 ? pages[0] : null)
 		} else {
 			console.warn('WKG_Page_Selector doit recevoir la propriété \'onChange={value => func()}\'')
 		}
 	}

	render () {
    let options = []
		if (this.props.pages) {
			options.push({value: 0, label: 'Selectionner une page'})
			this.props.pages.forEach((page) => {
				options.push({value: page.id, label: page.title.rendered})
			})
		} else {
			options.push({value: 0, label: 'Loading...'})
		}
  	return (
			<div style={styles.selector}>
				<SelectControl
          label={this.props.label}
					options={options}
					onChange={value => this._onChange(value)}
					value={this.state.selected}
				/>
			</div>
    )
  }
}

const applyWithSelect = withSelect(select => {
		const { getEntityRecords } = select('core')
    let page_query = {
      per_page: -1,
      //exclude: postId,
      //parent_exclude: postId,
      //orderby: 'menu_order',
      //order: 'asc',
      //status: 'publish,future,draft,pending,private',
    }
    return { pages: getEntityRecords('postType', 'page', page_query) }
})

export default compose(
    applyWithSelect,
)(WKG_Page_Selector)

const styles = {
	selector: {
		width: '100%',
		height: '100%',
    position: 'relative',
		padding: '12px',
	}
}
