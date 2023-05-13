import dayjs from "dayjs"
import relativeTime from 'dayjs/plugin/relativeTime'
export default (date) => dayjs.extend(relativeTime)(date).fromNow()