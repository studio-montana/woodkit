const { Component } = wp.element
const { Button, CheckboxControl } = wp.components
const { compose } = wp.compose
const { withSelect, withDispatch } = wp.data

 class WKG_Category_Selector extends Component {

	constructor (props) {
    super(props)
		this.state = {
			selected: []
		}
  }

	componentDidMount () {
		this.setState({
			selected: this.props.value
		})
	}

	async _onChange (value, checked) {
		if (this.props.onChange) {
      let selected = null
      if (checked) {
        selected = this.state.selected
        selected.push(parseInt(value))
      } else {
        selected = this.state.selected.filter(id => id !== parseInt(value))
      }
			await this.setState({selected})
			let selected_objects = this.props.categories.filter(p => this.state.selected.indexOf(p.id) !== -1)
			this.props.onChange(this.state.selected, selected_objects)
		} else {
			console.warn('WKG_Category_Selector doit recevoir la propriété \'onChange={value => func()}\'')
		}
	}

	render () {
		let checkboxes = []
		if (this.props.categories) {
			this.props.categories.forEach((term) => {
        let checked = this.state.selected.indexOf(term.id) !== -1
				checkboxes.push(
          <CheckboxControl value={term.id} label={term.name} checked={checked} onChange={checked => this._onChange(term.id, checked)} />
        )
			})
		} else {
			checkboxes.push(<div>Loading...</div>)
		}
    let selectedId = this.state.selected ? this.state.selected.id : 0
  	return (
			<div style={styles.selector}>
				{checkboxes}
			</div>
    )
  }
}

const applyWithSelect = withSelect(select => {
		const { getEntityRecords } = select('core')
    return { categories: getEntityRecords('taxonomy', 'category') }
})

export default compose(
    applyWithSelect,
)(WKG_Category_Selector)

const styles = {
	selector: {
		width: '100%',
		height: '100%',
    position: 'relative',
		padding: '12px',
	}
}
