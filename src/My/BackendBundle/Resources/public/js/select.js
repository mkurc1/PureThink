/**
 * Object Select Constructor
 */
function Select() {
    this.select = [];

    this.add = add;
    this.get = get;
    this.getAll = getAll;
    this.remove = remove;
    this.empty = empty;
    this.count = count;

    function add(id) {
        this.select.push(id);
    }

    function get(index) {
        return this.select[index];
    }

    function getAll() {
        return this.select;
    }

    function remove(id) {
        var i = this.select.indexOf(id);
        if(i != -1) {
            this.select.splice(i, 1);
        }
    }

    function empty() {
        this.select.clear();
    }

    function count() {
        return this.select.length;
    }
}