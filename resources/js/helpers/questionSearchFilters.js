const filtersList = [ 'noAnswers', 'subject' ]

export default {
    get(){
        const parsed = new URLSearchParams(location.search)
        const result = {}
        for (let filterName of filtersList){
            if (parsed.get(filterName))
                result[filterName] = parsed.get(filterName)

        }
        return result
    },
    applyFilter(key, value){
        const current = this.get()
        current[key] = value
        return '?' + new URLSearchParams(current).toString()
    },
    removeFilter(key){
        const current = this.get()
        Reflect.deleteProperty(current, key)
        return '?' + new URLSearchParams(current).toString()
    }
}