const { Component } = wp.element
const { SelectControl, Placeholder } = wp.components
const { compose } = wp.compose
const { withSelect, withDispatch } = wp.data
const { apiRequest } = wp

class WKG_CF7_Selector extends Component {

	constructor (props) {
    super(props)
		this.state = {
			selected: null
		}
  }

	componentDidMount () {
		this.setState({
			selected: this.props.value
		})
	}

	_onChange (value) {
		if (this.props.onChange) {
			this.setState({
				selected: value
			})
			this.props.onChange(value)
		} else {
			console.warn('WKG_CF7_Selector doit recevoir la propriété \'onChange={value => func()}\'')
		}
	}

	render () {
		let options = this.props.cf7Options ? [{value: 0, label: 'Selectionner un formulaire'}] : [{value: 0, label: 'Loading...'}]
		if (this.props.cf7Options) {
			options = options.concat(this.props.cf7Options)
		}
  	return (
			<div style={styles.content}>
				<div style={styles.selector}>
          <Placeholder
    				key="cf-7-block"
    				icon="email"
    				label="Contact Form 7">
  					<SelectControl
  						options={options}
  						onChange={value => this._onChange(parseInt(value))}
  						value={this.state.selected}
  					/>
          </Placeholder>
				</div>
			</div>
    )
  }
}

const applyWithSelect = withSelect(select => {
  const cf7Options = select('wkg/commons').getCf7Options()
  return { cf7Options }
})

const applyWithDispatch = withDispatch(dispatch => {
    const { createNotice } = dispatch('core/notices')
    return { createNotice: createNotice }
})

export default compose(
    applyWithSelect,
    applyWithDispatch,
)(WKG_CF7_Selector)

const styles = {
  content: {
		width: '100%',
		height: '100%',
    position: 'relative',
	},
	selector: {
		padding: '12px',
	}
}
