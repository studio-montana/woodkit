const { registerPlugin } = wp.plugins
const { Component, Fragment } = wp.element
const { withSelect, withDispatch } = wp.data
const { compose } = wp.compose
const { PluginDocumentSettingPanel } = wp.editPost

registerPlugin('wkg-plugin-_blank_', {
  icon: 'admin-customizer',
  render: (props) => {
    return (
      <PluginDocumentSettingPanel name="wkg-plugin-_blank_" title="Custom Panel" className="wkg-document-setting-panel wkg-plugin-_blank_">
          <PluginComponent />
      </PluginDocumentSettingPanel>
    )
  }
})

class PluginComponent_Base extends Component {
	constructor(props) {
		super(props)
	}
	render () {
		return (
			<Fragment>
				<div className="wkg-content">
          <div className="wkg-panel-row">
            <div className="wkg-description">
              Ajoutez ce que vous voulez !
            </div>
          </div>
				</div>
			</Fragment>
		)
	}
}

const applyWithSelect = withSelect(select => {
  let core_editor_store = select('core/editor')
  return {
    meta_icon: core_editor_store.getEditedPostAttribute('meta')['_custom_meta_name'],
  }
})

const applyWithDispatch = withDispatch(dispatch => {
  let core_editor_store = dispatch('core/editor')
  return {
    on_custom_meta_name_change: (value) => {
      core_editor_store.editPost({meta: {'_custom_meta_name': value}})
    },
  }
})

const PluginComponent = compose(
    applyWithSelect,
    applyWithDispatch,
)(PluginComponent_Base)

const styles = {}
