/**
 * Object Select Cunstructor
 */
function Select() {
    this.select = [];

    this.add = add;
    this.get = get;
    this.getAll = getAll;
    this.remove = remove;
    this.empty = empty;
    this.count = count;

    /**
     * Add
     *
     * @param integer id
     */
    function add(id) {
        this.select.push(id);
    }

    /**
     * Get
     *
     * @param integer index
     * @return ID
     */
    function get(index) {
        return this.select[index];
    }

    /**
     * Get all
     *
     * @return array
     */
    function getAll() {
        return this.select;
    }

    /**
     * Remove
     *
     * @param integer id
     */
    function remove(id) {
        var i = this.select.indexOf(id);
        if(i != -1) {
            this.select.splice(i, 1);
        }
    }

    /**
     * Empty
     */
    function empty() {
        this.select.clear();
    }

    /**
     * Count
     *
     * @return integer
     */
    function count() {
        return this.select.length;
    }
}